<?php declare(strict_types=1);

namespace Tests\Feature;

use App\User;
use Generator;
use App\Period;
use App\History;
use Tests\TestCase;
use App\Events\BoardUpdated;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MovePeriodTest extends TestCase
{
    use RefreshDatabase;

    private History $history;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->history = factory(History::class)->create([
            'owner_id' => $this->user->id,
        ]);
    }

    /** @test */
    public function movePeriodDownASlot(): void
    {
        $period1 = factory(Period::class)->create([
            'history_id' => $this->history->id,
            'position' => 1
        ]);
        $period2 = factory(Period::class)->create([
            'history_id' => $this->history->id,
            'position' => 2
        ]);

        $period1->move(2);

        $this->assertSame($period1->refresh()->position, 2);
        $this->assertSame($period2->refresh()->position, 1);
    }

    /** @test */
    public function movePeriodUpASlot()
    {
        $period1 = factory(Period::class)->create([
            'history_id' => $this->history->id,
            'position' => 1
        ]);
        $period2 = factory(Period::class)->create([
            'history_id' => $this->history->id,
            'position' => 2
        ]);

        $period2->move(1);

        $this->assertSame($period1->refresh()->position, 2);
        $this->assertSame($period2->refresh()->position, 1);
    }

    /** @test */
    public function movePeriodDownTwoSlots(): void
    {
        $period1 = factory(Period::class)->create([
            'history_id' => $this->history->id,
            'position' => 1
        ]);
        $period2 = factory(Period::class)->create([
            'history_id' => $this->history->id,
            'position' => 2
        ]);
        $period3 = factory(Period::class)->create([
            'history_id' => $this->history->id,
            'position' => 3
        ]);

        $period1->move(3);

        $this->assertSame($period1->refresh()->position, 3);
        $this->assertSame($period2->refresh()->position, 1);
        $this->assertSame($period3->refresh()->position, 2);
    }

    /** @test */
    public function moveUpTwoSlotsPeriod()
    {
        $period1 = factory(Period::class)->create([
            'history_id' => $this->history->id,
            'position' => 1
        ]);
        $period2 = factory(Period::class)->create([
            'history_id' => $this->history->id,
            'position' => 2
        ]);
        $period3 = factory(Period::class)->create([
            'history_id' => $this->history->id,
            'position' => 3
        ]);

        $period3->move(1);

        $this->assertSame($period1->refresh()->position, 2);
        $this->assertSame($period2->refresh()->position, 3);
        $this->assertSame($period3->refresh()->position, 1);
    }

    /** @test */
    public function movePeriodDownInBetweenTwoPeriods(): void
    {
        $period1 = factory(Period::class)->create([
            'history_id' => $this->history->id,
            'position' => 1
        ]);
        $period2 = factory(Period::class)->create([
            'history_id' => $this->history->id,
            'position' => 2
        ]);
        $period3 = factory(Period::class)->create([
            'history_id' => $this->history->id,
            'position' => 3
        ]);
        $period4 = factory(Period::class)->create([
            'history_id' => $this->history->id,
            'position' => 4
        ]);

        $period2->move(3);

        $this->assertSame($period1->refresh()->position, 1);
        $this->assertSame($period2->refresh()->position, 3);
        $this->assertSame($period3->refresh()->position, 2);
        $this->assertSame($period4->refresh()->position, 4);
    }

    /** @test */
    public function movePeriodUpInBetweenTwoPeriods(): void
    {
        $period1 = factory(Period::class)->create([
            'history_id' => $this->history->id,
            'position' => 1
        ]);
        $period2 = factory(Period::class)->create([
            'history_id' => $this->history->id,
            'position' => 2
        ]);
        $period3 = factory(Period::class)->create([
            'history_id' => $this->history->id,
            'position' => 3
        ]);
        $period4 = factory(Period::class)->create([
            'history_id' => $this->history->id,
            'position' => 4
        ]);

        $period3->move(2);

        $this->assertSame($period1->refresh()->position, 1);
        $this->assertSame($period2->refresh()->position, 3);
        $this->assertSame($period3->refresh()->position, 2);
        $this->assertSame($period4->refresh()->position, 4);
    }

    /** @test */
    public function broadcastEventAfterPeriodHasBeenMoved(): void
    {
        Event::fake();

        factory(Period::class)->create([
            'history_id' => $this->history->id,
            'position' => 2
        ]);
        $period = factory(Period::class)->create([
            'history_id' => $this->history->id,
            'position' => 1
        ]);

        $this->login()->postJson(route('history.periods.move', [$this->history, $period]), [
            'position' => 2,
        ]);

        Event::assertDispatched(
            BoardUpdated::class,
            fn (BoardUpdated $event) => $event->history->id === $period->history->id
        );
    }

    /**
     * @test
     * @dataProvider invalidPositionProvider
     */
    public function validatePosition(array $payload): void
    {
        $period = factory(Period::class)->create([
            'history_id' => $this->history->id,
            'position' => 1
        ]);

        $response = $this->login()->postJson(route('history.periods.move', [$this->history, $period]), $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('position');
    }

    public function invalidPositionProvider(): Generator
    {
        yield from [
            'missing' => [[]],
            'negative' => [['position' => -1]],
            'zero' => [['position' => 0]],
            'non numeric' => [['position' => 'two']],
        ];
    }

    /** @test */
    public function canOnlyMovePeriodsBelongingToOwnHistory()
    {
        $otherUser = factory(User::class)->create();
        $period = factory(Period::class)->create([
            'history_id' => $this->history->id,
            'position' => 1
        ]);

        $response = $this->actingAs($otherUser)->postJson(route('history.periods.move', [$this->history, $period]), [
            'position' => 2,
        ]);

        $response->assertForbidden();
    }
}
