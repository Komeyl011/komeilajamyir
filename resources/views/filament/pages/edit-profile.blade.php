<x-filament-panels::page>
    <x-filament-panels::form>
        {{ $this->editProfileForm }}
        <x-filament-panels::form.actions
            :actions="$this->getUpdateProfileFormActions()"
        />
    </x-filament-panels::form>
    <x-filament-panels::form>
        {{ $this->editPasswordForm }}
        <x-filament-panels::form.actions
            :actions="$this->getUpdatePasswordFormActions()"
        />
    </x-filament-panels::form>
</x-filament-panels::page>
