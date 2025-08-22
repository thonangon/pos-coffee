<div>
    <div
        class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px">
            <li class="me-2">
                <a href="#" wire:click.prevent="setActiveSetting('restaurant')" @class([
                    'inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300',
                    'border-transparent' => $activeSetting != 'restaurant',
                    'active border-skin-base dark:text-skin-base dark:border-skin-base text-skin-base' =>
                        $activeSetting == 'restaurant',
                ])>
                    Restaurant Settings
                </a>
            </li>
            <li class="me-2">
                <a href="#" wire:click.prevent="setActiveSetting('branch')" @class([
                    'inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300',
                    'border-transparent' => $activeSetting != 'branch',
                    'active border-skin-base dark:text-skin-base dark:border-skin-base text-skin-base' =>
                        $activeSetting == 'branch',
                ])>Branch Settings</a>
            </li>
            <li class="me-2">
                <a href="#" wire:click.prevent="setActiveSetting('tax')" @class([
                    'inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300',
                    'border-transparent' => $activeSetting != 'tax',
                    'active border-skin-base dark:text-skin-base dark:border-skin-base text-skin-base' =>
                        $activeSetting == 'tax',
                ])>Tax Settings</a>
            </li>
            <li class="me-2">
                <a href="#" wire:click.prevent="setActiveSetting('payment')" @class([
                    'inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300',
                    'border-transparent' => $activeSetting != 'payment',
                    'active border-skin-base dark:text-skin-base dark:border-skin-base text-skin-base' =>
                        $activeSetting == 'payment',
                ])>Payment Gateway</a>
            </li>
            <li class="me-2">
                <a href="#" wire:click.prevent="setActiveSetting('theme')" @class([
                    'inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300',
                    'border-transparent' => $activeSetting != 'theme',
                    'active border-skin-base dark:text-skin-base dark:border-skin-base text-skin-base' =>
                        $activeSetting == 'theme',
                ])>Theme Setting</a>
            </li>
            <li class="me-2">
                <a href="#" wire:click.prevent="setActiveSetting('role')" @class([
                    'inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300',
                    'border-transparent' => $activeSetting != 'role',
                    'active border-skin-base dark:text-skin-base dark:border-skin-base text-skin-base' =>
                        $activeSetting == 'role',
                ])>role Settings</a>
            </li>
            <li class="me-2">
                <a href="#" wire:click.prevent="setActiveSetting('aboutus')" @class([
                    'inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300',
                    'border-transparent' => $activeSetting != 'aboutus',
                    'active border-skin-base dark:text-skin-base dark:border-skin-base text-skin-base' =>
                        $activeSetting == 'aboutus',
                ])>About Us </a>
            </li>
            <li class="me-2">
                <a href="#" wire:click.prevent="setActiveSetting('customerSite')" @class([
                    'inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300',
                    'border-transparent' => $activeSetting != 'customerSite',
                    'active border-skin-base dark:text-skin-base dark:border-skin-base text-skin-base' =>
                        $activeSetting == 'customerSite',
                ])>Customer Site</a>
            </li>
            <li class="me-2">
                <a href="#" wire:click.prevent="setActiveSetting('receipt')" @class([
                    'inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300',
                    'border-transparent' => $activeSetting != 'receipt',
                    'active border-skin-base dark:text-skin-base dark:border-skin-base text-skin-base' =>
                        $activeSetting == 'receipt',
                ])>Receipt Setting</a>
            </li>
            <li class="me-2">
                <a href="#" wire:click.prevent="setActiveSetting('customer-display-ads')" @class([
                    'inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300',
                    'border-transparent' => $activeSetting != 'customer-display-ads',
                    'active border-skin-base dark:text-skin-base dark:border-skin-base text-skin-base' =>
                        $activeSetting == 'customer-display-ads',
                ])>Customer Display Ads</a>
            </li>
            <li class="me-2">
                <a href="#" wire:click.prevent="setActiveSetting('orderSettings')" @class([
                    'inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300',
                    'border-transparent' => $activeSetting != 'orderSettings',
                    'active border-skin-base dark:text-skin-base dark:border-skin-base text-skin-base' =>
                        $activeSetting == 'orderSettings',
                ])>Order Setting</a>
            </li>
        </ul>
    </div>
    <div class="grid grid-cols-1 pt-6 dark:bg-gray-900">
        <div>
            @switch($activeSetting)
                @case('restaurant')
                    @livewire('settings.generalSettings', ['settings' => $settings])
                @break
                @case('app')
                    @livewire('settings.timezoneSettings', ['settings' => $settings])
                @break
                @case('email')
                    @livewire('settings.notificationSettings', ['settings' => $settings])
                @break
                @case('telegram')
                    @livewire('settings.telegramSettings', ['settings' => $settings])
                @break
                @case('currency')
                    @livewire('settings.currencySettings')
                @break
                @case('exchange')
                    @livewire('settings.ExchangeRateSettings')
                @break
                @case('payment')
                    @livewire('settings.paymentSettings', ['settings' => $settings])
                @break
                @case('theme')
                    @livewire('settings.themeSettings', ['settings' => $settings])
                @break
                @case('role')
                    @livewire('settings.roleSettings', ['settings' => $settings])
                @break
                @case('tax')
                    @livewire('settings.taxSettings')
                @break
                @case('branch')
                    @livewire('settings.branchSetting')
                @break
                @case('billing')
                    @livewire('settings.billingSettings')
                @break
                @case('aboutus')
                    @livewire('settings.aboutUsSettings', ['settings' => $settings])
                @break
                @case('customerSite')
                    @livewire('settings.customerSiteSettings', ['settings' => $settings])
                @break
                @case('customer-display-ads')
                    @livewire('settings.customerDisplayAdsSettings', ['settings' => $settings])
                @break
                @case('receipt')
                    @livewire('settings.ReceiptSetting', ['settings' => $settings])
                @break
                @case('orderSettings')
                    @livewire('settings.OrderSettings', ['settings' => $settings])
                @break
                @default
            @endswitch
        </div>
    </div>
</div>