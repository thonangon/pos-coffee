<?php

namespace App\Livewire\Settings;

use Livewire\Component;

class Master extends Component
{
    public $settings;
    public $activeSetting;

    public function mount()
    {
        // Set the active setting based on the 'tab' query parameter, or default to 'restaurant'
        $this->activeSetting = request('tab') ? request('tab') : 'restaurant';
    }
    
    // #[On('settingsUpdated')]
    public function refreshSettings()
    {
        session()->forget(['restaurant', 'timezone', 'currency']);

        $this->settings->fresh();
    }

    // Method to set the active tab
    public function setActiveSetting($tab)
    {
        $this->activeSetting = $tab;
    }

    public function render()
    {
        return view('livewire.settings.master');
    }
}