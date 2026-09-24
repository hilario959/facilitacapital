<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use App\Support\SiteContent;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\BaseFileUpload;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class EditSite extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSwatch;

    protected static ?string $navigationLabel = 'Contenido del sitio';

    protected static ?string $title = 'Contenido del sitio';

    protected static ?string $slug = 'contenido';

    protected static ?int $navigationSort = 2;

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(SiteSetting::content());
    }

    public function defaultForm(Schema $schema): Schema
    {
        return $schema->statePath('data');
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Contenido')
                ->persistTabInQueryString()
                ->tabs([
                    Tab::make('Colores')->schema([
                        Section::make('Paleta')->columns(3)->schema($this->colorFields()),
                    ]),
                    Tab::make('Marca')->schema([
                        Section::make('Nombre y logo')->columns(2)->schema([
                            TextInput::make('brand.line1')->label('Línea 1')->required()->maxLength(40),
                            TextInput::make('brand.line2')->label('Línea 2')->required()->maxLength(40),
                            $this->imageUpload('brand.logo')
                                ->label('Logo (opcional)')
                                ->helperText('Si subes un logo, reemplaza el isotipo del sitio.')
                                ->maxSize(2048)
                                ->columnSpanFull(),
                        ]),
                        Section::make('Navegación')->schema([
                            TextInput::make('nav.cta')->label('Botón del menú')->required()->maxLength(80),
                            TextInput::make('mobile_cta')->label('Botón fijo en móvil')->required()->maxLength(80),
                            Repeater::make('nav.links')
                                ->label('Enlaces')
                                ->schema([
                                    TextInput::make('label')->label('Texto')->required()->maxLength(40),
                                    TextInput::make('href')->label('Destino')->required()->maxLength(80)->helperText('Usa un ancla como #calculadora.'),
                                ])
                                ->columns(2)
                                ->minItems(1)
                                ->maxItems(6)
                                ->itemLabel(fn (array $state): ?string => $state['label'] ?? null),
                        ]),
                        Section::make('Buscadores')->schema([
                            TextInput::make('seo.title')->label('Título de la página')->required()->maxLength(120)->columnSpanFull(),
                            Textarea::make('seo.description')->label('Descripción')->required()->rows(3)->maxLength(300)->columnSpanFull(),
                        ]),
                    ]),
                    Tab::make('Inicio')->schema([
                        Section::make('Hero')->columns(2)->schema([
                            TextInput::make('hero.eyebrow')->label('Antetítulo')->required()->columnSpanFull(),
                            Textarea::make('hero.title')->label('Título')->required()->rows(2)->columnSpanFull(),
                            Textarea::make('hero.lead')->label('Texto')->required()->rows(3)->columnSpanFull(),
                            TextInput::make('hero.primary_cta')->label('Botón principal')->required(),
                            TextInput::make('hero.secondary_cta')->label('Botón secundario')->required(),
                            $this->imageUpload('hero.image')->label('Foto')->required()->maxSize(5120),
                            TextInput::make('hero.image_alt')->label('Texto alternativo de la foto')->required(),
                            TextInput::make('hero.float_kicker')->label('Tarjeta: antetítulo')->required(),
                            TextInput::make('hero.float_amount')->label('Tarjeta: monto')->numeric()->prefix('Q')->required(),
                            TextInput::make('hero.float_meta')->label('Tarjeta: detalle')->required()->columnSpanFull(),
                        ]),
                        Section::make('Problema')->schema([
                            TextInput::make('problem.line_1')->label('Frase destacada')->required(),
                            Textarea::make('problem.line_2')->label('Pregunta')->required()->rows(2),
                            Textarea::make('problem.text')->label('Texto')->required()->rows(3),
                            $this->imageUpload('problem.image')->label('Foto de fondo')->required()->maxSize(5120),
                            TextInput::make('problem.image_alt')->label('Texto alternativo')->required(),
                        ]),
                    ]),
                    Tab::make('Beneficios')->schema([
                        TextInput::make('benefits.eyebrow')->label('Antetítulo')->required(),
                        Repeater::make('benefits.items')
                            ->label('Tarjetas')
                            ->schema([
                                TextInput::make('title')->label('Título')->required()->maxLength(40),
                                Textarea::make('text')->label('Texto')->required()->rows(2),
                            ])
                            ->minItems(1)
                            ->maxItems(6)
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null),
                        Textarea::make('benefits.tagline')->label('Frase')->required()->rows(2),
                        Textarea::make('benefits.tagline_note')->label('Nota')->required()->rows(2),
                    ]),
                    Tab::make('Pasos')->schema([
                        TextInput::make('steps.eyebrow')->label('Antetítulo')->required(),
                        TextInput::make('steps.title')->label('Título')->required(),
                        Textarea::make('steps.lead')->label('Texto')->required()->rows(3),
                        Repeater::make('steps.items')
                            ->label('Pasos')
                            ->schema([
                                TextInput::make('title')->label('Título')->required(),
                                Textarea::make('text')->label('Texto')->required()->rows(2),
                            ])
                            ->minItems(1)
                            ->maxItems(6)
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null),
                    ]),
                    Tab::make('Casos')->schema([
                        TextInput::make('cases.eyebrow')->label('Antetítulo')->required(),
                        TextInput::make('cases.title')->label('Título')->required(),
                        Textarea::make('cases.lead')->label('Texto')->required()->rows(3),
                        Repeater::make('cases.items')
                            ->label('Casos')
                            ->schema([
                                TextInput::make('name')->label('Nombre')->required(),
                                TextInput::make('sector')->label('Sector')->required(),
                                TextInput::make('title')->label('Uso')->required(),
                                Textarea::make('text')->label('Texto')->required()->rows(2)->columnSpanFull(),
                                $this->imageUpload('image')->label('Foto')->required()->maxSize(5120)->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->minItems(1)
                            ->maxItems(8)
                            ->itemLabel(fn (array $state): ?string => $state['name'] ?? null),
                    ]),
                    Tab::make('Calculadora')->schema([
                        Section::make('Textos')->schema([
                            TextInput::make('calculator.eyebrow')->label('Antetítulo')->required(),
                            TextInput::make('calculator.title')->label('Título')->required(),
                            Textarea::make('calculator.lead')->label('Texto')->required()->rows(3),
                            TextInput::make('calculator.amount_label')->label('Etiqueta del monto')->required(),
                            TextInput::make('calculator.term_label')->label('Etiqueta del plazo')->required(),
                            TextInput::make('calculator.result_kicker')->label('Resultado: antetítulo')->required(),
                            Textarea::make('calculator.vs')->label('Comparación')->helperText('Puedes usar {days}.')->required()->rows(2),
                            TextInput::make('calculator.row_amount')->label('Fila: valor')->required(),
                            TextInput::make('calculator.row_advance')->label('Fila: adelanto')->required(),
                            TextInput::make('calculator.row_cost')->label('Fila: costo')->required(),
                            TextInput::make('calculator.row_holdback')->label('Fila: saldo')->required(),
                            TextInput::make('calculator.cta')->label('Botón')->required(),
                            Textarea::make('calculator.note')->label('Nota legal')->required()->rows(3),
                        ]),
                        Section::make('Formulario del monto')->schema([
                            TextInput::make('lead_form.title')->label('Título')->required(),
                            Textarea::make('lead_form.lead')->label('Texto')->required()->rows(2),
                            TextInput::make('lead_form.email_label')->label('Etiqueta de correo')->required(),
                            TextInput::make('lead_form.whatsapp_label')->label('Etiqueta de WhatsApp')->required(),
                            TextInput::make('lead_form.nit_label')->label('Etiqueta de NIT')->required(),
                            TextInput::make('lead_form.submit')->label('Botón de envío')->required(),
                            TextInput::make('lead_form.sending')->label('Botón mientras envía')->required(),
                            TextInput::make('lead_form.success_title')->label('Título de confirmación')->required(),
                            Textarea::make('lead_form.success_text')->label('Mensaje de confirmación')->helperText('Puedes usar {email}, {amount}, {today}, {days}, {whatsapp} y {nit}.')->required()->rows(3),
                            Textarea::make('lead_form.fine')->label('Nota pequeña')->required()->rows(2),
                        ]),
                    ]),
                    Tab::make('Califico')->schema([
                        TextInput::make('qualify.eyebrow')->label('Antetítulo')->required(),
                        TextInput::make('qualify.title')->label('Título')->required(),
                        Textarea::make('qualify.lead')->label('Texto')->required()->rows(2),
                        Repeater::make('qualify.items')
                            ->label('Criterios')
                            ->simple(TextInput::make('item')->required())
                            ->minItems(1)
                            ->maxItems(8),
                    ]),
                    Tab::make('Pie')->schema([
                        Textarea::make('footer.text')->label('Texto')->required()->rows(3),
                        TextInput::make('footer.copyright')->label('Derechos')->required(),
                    ]),
                    Tab::make('Correo')->schema([
                        Section::make('Correo al cliente')
                            ->description('Se envía al correo que dejan en la calculadora. Puedes usar {amount}, {today}, {days}, {email}, {whatsapp} y {nit}.')
                            ->schema([
                                TextInput::make('mail.subject')->label('Asunto')->required()->maxLength(160),
                                TextInput::make('mail.greeting')->label('Saludo')->required(),
                                Textarea::make('mail.body')->label('Mensaje')->required()->rows(5),
                                TextInput::make('mail.closing')->label('Cierre')->required(),
                            ]),
                    ]),
                ]),
        ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            Form::make([EmbeddedSchema::make('form')])
                ->id('site-form')
                ->livewireSubmitHandler('save')
                ->footer([
                    Actions::make([
                        Action::make('save')
                            ->label('Guardar cambios')
                            ->submit('save'),
                    ])->key('site-form-actions'),
                ]),
        ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $data = $this->sanitize($data);

        SiteSetting::current()->update(['data' => $data]);

        Notification::make()
            ->success()
            ->title('Cambios guardados')
            ->body('El sitio público ya usa estos textos, colores e imágenes.')
            ->send();
    }

    private function imageUpload(string $name): FileUpload
    {
        $disk = config('filesystems.media_disk', 'public');

        return FileUpload::make($name)
            ->image()
            ->disk(is_string($disk) ? $disk : 'public')
            ->directory('site')
            ->fetchFileInformation(false)
            ->getUploadedFileUsing(function (string $file): array {
                return [
                    'name' => basename($file),
                    'size' => 0,
                    'type' => null,
                    'url' => SiteContent::url($file),
                ];
            })
            ->saveUploadedFileUsing(function (BaseFileUpload $component, TemporaryUploadedFile $file): ?string {
                if ($component->getDiskName() === 'public') {
                    return $component->saveUploadedFile($file);
                }

                $extension = $file->getClientOriginalExtension();
                $path = trim($component->getDirectory().'/'.(string) str()->ulid().($extension !== '' ? '.'.$extension : ''), '/');
                $component->getDisk()->put($path, $file->get());

                return $path;
            });
    }

    /**
     * @return list<ColorPicker>
     */
    private function colorFields(): array
    {
        $labels = [
            'brand' => 'Marca',
            'brand_2' => 'Marca al pasar el cursor',
            'on_brand' => 'Texto sobre la marca',
            'lime' => 'Acento claro',
            'mint' => 'Menta',
            'dark' => 'Fondo oscuro',
            'dark_2' => 'Fondo oscuro secundario',
            'paper' => 'Fondo',
            'paper_2' => 'Fondo suave',
            'ink' => 'Texto',
            'ink_2' => 'Texto secundario',
            'ink_3' => 'Texto tenue',
        ];

        $fields = [];
        foreach ($labels as $key => $label) {
            $fields[] = ColorPicker::make('colors.'.$key)->label($label)->required();
        }

        return $fields;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function sanitize(array $data): array
    {
        $defaults = SiteContent::defaults();

        foreach ($defaults['colors'] as $key => $fallback) {
            $value = $data['colors'][$key] ?? '';
            if (! is_string($value) || ! preg_match('/^#[0-9A-Fa-f]{6}$/', $value)) {
                $data['colors'][$key] = $fallback;
            }
        }

        $links = [];
        foreach ($data['nav']['links'] ?? [] as $link) {
            if (! is_array($link)) {
                continue;
            }
            $href = trim((string) ($link['href'] ?? ''));
            if (! preg_match('/^#[A-Za-z0-9\-]+$/', $href) && ! preg_match('/^\/[A-Za-z0-9\-\/]*$/', $href)) {
                $href = '#calculadora';
            }
            $links[] = [
                'label' => trim((string) ($link['label'] ?? '')),
                'href' => $href,
            ];
        }
        $data['nav']['links'] = $links;

        $data['brand']['logo'] = $this->fileValue($data['brand']['logo'] ?? null);
        $data['hero']['image'] = $this->fileValue($data['hero']['image'] ?? null);
        $data['problem']['image'] = $this->fileValue($data['problem']['image'] ?? null);

        foreach ($data['cases']['items'] ?? [] as $index => $item) {
            if (! is_array($item)) {
                continue;
            }
            $data['cases']['items'][$index]['image'] = $this->fileValue($item['image'] ?? null);
        }

        return $data;
    }

    private function fileValue(mixed $value): ?string
    {
        if (is_array($value)) {
            $value = $value[0] ?? null;
        }

        return is_string($value) && $value !== '' ? $value : null;
    }
}
