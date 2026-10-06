<?php

namespace Tests\Feature;

use App\Models\Challenge;
use App\Models\Participation;
use App\Models\Result;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LevelUpFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_can_access_member_dashboard(): void
    {
        $member = User::factory()->create([
            'role' => 'member',
        ]);

        $response = $this
            ->actingAs($member)
            ->get('/member/dashboard');

        $response->assertStatus(200);
    }

    public function test_member_cannot_access_coach_pages(): void
    {
        $member = User::factory()->create([
            'role' => 'member',
        ]);

        $response = $this
            ->actingAs($member)
            ->get('/coach/challenges');

        $response->assertStatus(403);
    }

    public function test_coach_cannot_access_member_pages(): void
    {
        $coach = User::factory()->create([
            'role' => 'coach',
        ]);

        $response = $this
            ->actingAs($coach)
            ->get('/member/dashboard');

        $response->assertStatus(403);
    }

    public function test_member_can_join_active_challenge(): void
    {
        $coach = User::factory()->create([
            'role' => 'coach',
        ]);

        $member = User::factory()->create([
            'role' => 'member',
        ]);

        $challenge = Challenge::create([
            'created_by' => $coach->id,
            'name' => 'Test Challenge',
            'unit' => 'km',
            'start_date' => today()->subDay(),
            'end_date' => today()->addWeek(),
            'rules' => 'Testregels',
            'min_value' => 1,
            'max_value' => 50,
            'leaderboard_published' => false,
        ]);

        $response = $this
            ->actingAs($member)
            ->post(route('member.challenges.join', $challenge));

        $response->assertRedirect();

        $this->assertDatabaseHas('participations', [
            'user_id' => $member->id,
            'challenge_id' => $challenge->id,
        ]);
    }

    public function test_result_above_challenge_maximum_is_rejected(): void
    {
        $coach = User::factory()->create([
            'role' => 'coach',
        ]);

        $member = User::factory()->create([
            'role' => 'member',
        ]);

        $challenge = Challenge::create([
            'created_by' => $coach->id,
            'name' => 'Running Challenge',
            'unit' => 'km',
            'start_date' => today()->subDay(),
            'end_date' => today()->addWeek(),
            'rules' => 'Loop zoveel mogelijk kilometers.',
            'min_value' => 1,
            'max_value' => 50,
            'leaderboard_published' => false,
        ]);

        Participation::create([
            'user_id' => $member->id,
            'challenge_id' => $challenge->id,
            'joined_at' => now(),
        ]);

        $response = $this
            ->actingAs($member)
            ->post(route('member.results.store', $challenge), [
                'result_date' => today()->format('Y-m-d'),
                'value' => 60,
                'proof_url' => 'https://example.com/bewijs',
            ]);

        $response->assertSessionHasErrors('value');

        $this->assertDatabaseCount('results', 0);
    }

    public function test_valid_result_is_saved_as_pending(): void
    {
        $coach = User::factory()->create([
            'role' => 'coach',
        ]);

        $member = User::factory()->create([
            'role' => 'member',
        ]);

        $challenge = Challenge::create([
            'created_by' => $coach->id,
            'name' => 'Running Challenge',
            'unit' => 'km',
            'start_date' => today()->subDay(),
            'end_date' => today()->addWeek(),
            'rules' => 'Loop zoveel mogelijk kilometers.',
            'min_value' => 1,
            'max_value' => 50,
            'leaderboard_published' => false,
        ]);

        $participation = Participation::create([
            'user_id' => $member->id,
            'challenge_id' => $challenge->id,
            'joined_at' => now(),
        ]);

        $response = $this
            ->actingAs($member)
            ->post(route('member.results.store', $challenge), [
                'result_date' => today()->format('Y-m-d'),
                'value' => 10,
                'proof_url' => 'https://example.com/bewijs',
            ]);

        $response->assertRedirect(route('member.dashboard'));

        $this->assertDatabaseHas('results', [
            'participation_id' => $participation->id,
            'value' => 10,
            'status' => 'pending',
        ]);
    }

    public function test_leaderboard_only_contains_approved_results(): void
    {
        $coach = User::factory()->create([
            'role' => 'coach',
        ]);

        $approvedMember = User::factory()->create([
            'role' => 'member',
            'name' => 'Approved Member',
        ]);

        $pendingMember = User::factory()->create([
            'role' => 'member',
            'name' => 'Pending Member',
        ]);

        $challenge = Challenge::create([
            'created_by' => $coach->id,
            'name' => 'Leaderboard Challenge',
            'unit' => 'km',
            'start_date' => today()->subDay(),
            'end_date' => today()->addWeek(),
            'rules' => 'Test leaderboard.',
            'min_value' => 1,
            'max_value' => 100,
            'leaderboard_published' => true,
        ]);

        $approvedParticipation = Participation::create([
            'user_id' => $approvedMember->id,
            'challenge_id' => $challenge->id,
            'joined_at' => now(),
        ]);

        $pendingParticipation = Participation::create([
            'user_id' => $pendingMember->id,
            'challenge_id' => $challenge->id,
            'joined_at' => now(),
        ]);

        Result::create([
            'participation_id' => $approvedParticipation->id,
            'result_date' => today(),
            'value' => 25,
            'proof_url' => 'https://example.com/approved',
            'status' => 'approved',
        ]);

        Result::create([
            'participation_id' => $pendingParticipation->id,
            'result_date' => today(),
            'value' => 50,
            'proof_url' => 'https://example.com/pending',
            'status' => 'pending',
        ]);

        $response = $this
            ->actingAs($approvedMember)
            ->get(route('member.leaderboards.show', $challenge));

        $response->assertStatus(200);

        $response->assertSee('Approved Member');
        $response->assertDontSee('Pending Member');
    }
}