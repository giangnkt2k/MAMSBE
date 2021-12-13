<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CityTest extends DuskTestCase
{
    public function testGeneral()
    {
        $this->now = date('d-m-Y H:i:s');
        $this->login();
        $this->browse(function ($browser) {
            $this->create($browser);
            $this->update($browser);
            $this->del($browser);
        });
    }

    public function create($browser)
    {
        $browser->visit('/#/city/index')
            ->waitForText('Create New City', 5)->pause(3000)
            ->press('.btn_create')->pause(1000)
            ->waitForText('Submit', 5)
            ->typeSlowly('name', 'Auto test create ' . $this->now)->pause(1000)->releaseMouse()
            ->press(".btn_submit")->pause(1000)
            ->waitForText($this->now, 5)
            ->assertSee($this->now)->pause(5000);
    }

    public function update($browser)
    {
        $browser->waitFor('.btn-warning', 5)->pause(1000)
            ->press('.btn-warning')->pause(1000)
            ->waitFor('.is_ready', 5)
            ->typeSlowly('name', 'Auto test update ' . $this->now)->pause(1000)->releaseMouse()
            ->press(".btn-success")
            ->waitForText($this->now, 5)
            ->assertSee($this->now)->pause(2000);
    }

    public function del($browser)
    {
        $browser->waitFor('.btn-danger', 5)->pause(1000)
            ->press('.btn-danger')->pause(2000)
            ->waitForText('Are you sure to delete', 5)
            ->press("Yes")
            ->waitForText('Success', 5)
            ->assertSee('Success')->pause(2000);
    }
}
