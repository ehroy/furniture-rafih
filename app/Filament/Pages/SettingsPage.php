<?php
namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Support\Str;
use App\Helpers\SettingsHelper;
use Filament\Notifications\Notification;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Pages\Actions\Action as PageAction;
use Illuminate\Support\Facades\Artisan; // jangan lupa ini juga


class SettingsPage extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationLabel = 'Web Setting';
    protected static string $view = 'filament.pages.settings-page';
    protected static ?string $navigationGroup = 'General Settings';


    public $domain = '';
    public $name = '';
    public $tag = '';
    public $meta_author = '';
    public $meta_description = '';
    public $meta_keywords = '';
    public $action_button_text = '';
    public $no_whatsapp = '';
    public $wa_message = '';
    public $icon;
    public $logo;
    public ?array $data ;

    public function mount(): void
    {
        // Fetch the settings from the JSON file
        $settings = SettingsHelper::getSettings();
        $this->data = $settings;
      
        
        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('domain')->required(),
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('tag')->required(),
            Forms\Components\TextInput::make('meta_author')->required(),
            Forms\Components\TextInput::make('meta_description')->required(),
            Forms\Components\Textarea::make('meta_keywords')->required(),
            Forms\Components\TextInput::make('action_button_text')->required(),
            Forms\Components\TextInput::make('no_whatsapp')->required(),
            Forms\Components\TextInput::make('wa_message')->required(),
            Forms\Components\FileUpload::make('icon')->image(),
            Forms\Components\FileUpload::make('logo')->image()
            ])->statePath('data');
    }

    public function submit(): void
    {
        $data = $this->form->getState();

      

        // Save settings to the JSON file
        SettingsHelper::saveSettings($data);

        Notification::make()->title('Success')->icon('heroicon-o-check')->send();
    }

    protected function getFormModel(): string
    {
        return 'settings';
    }
    protected function getHeaderActions(): array
    {
        return [
            PageAction::make('Generate Sitemap')
                ->action(function () {
                    Artisan::call('generate:sitemap'); // pastikan command ini tersedia
                    Notification::make()
                        ->title('Sitemap berhasil dibuat!')
                        ->success()
                        ->send();
                })
                ->icon('heroicon-o-document-text')
                ->color('primary')
                ->label('Generate Sitemap (Last updated: ' . now()->format('d M Y H:i') . ')'),
        ];
    }

}
