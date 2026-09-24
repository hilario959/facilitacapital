<?php

namespace App\Support;

use App\Models\Lead;
use Illuminate\Support\Facades\Storage;

class SiteContent
{
    /**
     * @return array<string, mixed>
     */
    public static function defaults(): array
    {
        return [
            'colors' => [
                'paper' => '#ffffff',
                'paper_2' => '#e6f6ec',
                'ink' => '#0e0f0c',
                'ink_2' => '#454745',
                'ink_3' => '#868685',
                'brand' => '#00c94a',
                'brand_2' => '#00e056',
                'mint' => '#e8fff1',
                'lime' => '#c6ff4d',
                'dark' => '#163300',
                'dark_2' => '#1c3f0a',
                'on_brand' => '#04210d',
            ],
            'seo' => [
                'title' => 'Facilita Capital | Financiamiento al ritmo de los negocios',
                'description' => 'Facilita Capital adelanta el cobro de tus facturas. Capital al ritmo de tu empresa: transforma cuentas por cobrar en liquidez para crecer.',
            ],
            'brand' => [
                'line1' => 'Facilita',
                'line2' => 'Capital',
                'logo' => null,
            ],
            'nav' => [
                'cta' => 'Solicitar financiamiento',
                'links' => [
                    ['label' => 'Cómo funciona', 'href' => '#como-funciona'],
                    ['label' => 'Calculadora', 'href' => '#calculadora'],
                    ['label' => 'Casos de uso', 'href' => '#casos'],
                    ['label' => '¿Califico?', 'href' => '#califico'],
                ],
            ],
            'hero' => [
                'eyebrow' => 'Financiamiento al ritmo de los negocios',
                'title' => 'Capital al ritmo de tu empresa.',
                'lead' => 'Transforma tus cuentas por cobrar en liquidez para comprar inventario, pagar proveedores, tomar nuevas oportunidades y seguir creciendo.',
                'primary_cta' => 'Solicitar financiamiento',
                'secondary_cta' => '¿Cómo funciona?',
                'image' => 'site/hero-emprendedora.jpg',
                'image_alt' => 'Emprendedora adelantando facturas desde Facilita',
                'float_kicker' => 'Hoy puedes recibir',
                'float_amount' => 43200,
                'float_meta' => 'Factura F-1842 · 60 días',
            ],
            'problem' => [
                'image' => 'site/problem-negocio.jpg',
                'image_alt' => 'Emprendedores atendiendo su negocio',
                'line_1' => 'Tu empresa vende hoy.',
                'line_2' => '¿Por qué esperar 30, 60 o 90 días para utilizar ese dinero?',
                'text' => 'Facilita te permite adelantar el cobro de tus facturas para que el flujo de caja no limite el crecimiento de tu negocio.',
            ],
            'benefits' => [
                'eyebrow' => 'Por qué Facilita',
                'items' => [
                    ['title' => 'Ágil', 'text' => 'Evaluamos oportunidades rápidamente.'],
                    ['title' => 'Simple', 'text' => 'Un proceso claro, sin la burocracia de un banco tradicional.'],
                    ['title' => 'Flexible', 'text' => 'Financiamiento que se adapta al ciclo de tu empresa.'],
                ],
                'tagline' => 'Financiamiento al ritmo de los negocios.',
                'tagline_note' => 'Capital que se adapta al ciclo de tu empresa, no al de un banco tradicional.',
            ],
            'steps' => [
                'eyebrow' => 'Cómo funciona',
                'title' => 'Sólo tres pasos.',
                'lead' => 'El objetivo es simple: pasar de una factura pendiente a capital disponible, sin un proceso de banco tradicional.',
                'items' => [
                    ['title' => 'Cuéntanos sobre tu empresa', 'text' => 'Completa una solicitud sencilla.'],
                    ['title' => 'Evaluamos tus cuentas por cobrar', 'text' => 'Analizamos la operación y las facturas que quieres anticipar.'],
                    ['title' => 'Recibe liquidez', 'text' => 'Obtén capital para seguir operando y creciendo.'],
                ],
            ],
            'cases' => [
                'eyebrow' => 'Emprendedores Facilita',
                'title' => 'Liquidez con un propósito.',
                'lead' => 'Empresas que venden a crédito y adelantan el cobro para seguir operando. Esto es lo que desbloqueas cuando dejas de esperar el pago.',
                'items' => [
                    [
                        'title' => 'Compra inventario',
                        'text' => 'No pierdas oportunidades por esperar un pago.',
                        'name' => 'Daniela',
                        'sector' => 'Distribuidora',
                        'image' => 'site/case-daniela.jpg',
                    ],
                    [
                        'title' => 'Paga proveedores',
                        'text' => 'Mantén buenas relaciones y negocia mejores condiciones.',
                        'name' => 'Andrés',
                        'sector' => 'Alimentos',
                        'image' => 'site/case-andres.jpg',
                    ],
                    [
                        'title' => 'Toma nuevos proyectos',
                        'text' => 'Financia el crecimiento sin detener tu operación.',
                        'name' => 'Camila',
                        'sector' => 'Manufactura',
                        'image' => 'site/case-camila.jpg',
                    ],
                    [
                        'title' => 'Cubre capital de trabajo',
                        'text' => 'Haz que tus ventas trabajen para ti desde hoy.',
                        'name' => 'Luis',
                        'sector' => 'Logística',
                        'image' => 'site/case-luis.jpg',
                    ],
                ],
            ],
            'calculator' => [
                'eyebrow' => 'Calculadora',
                'title' => '¿Cuánto podrías recibir hoy?',
                'lead' => 'Estima tu liquidez al adelantar el cobro. Es una referencia, no una oferta. Las condiciones se definen al evaluar tu operación.',
                'amount_label' => 'Monto de tus facturas',
                'term_label' => 'Plazo de pago de tus clientes',
                'range_hint' => 'De {min} a {max}',
                'result_kicker' => 'Hoy puedes recibir',
                'vs' => 'Si esperas {days} días, hoy tienes Q0.00. Con Facilita, ese capital puede empezar a trabajar ahora.',
                'row_amount' => 'Valor de facturas',
                'row_advance' => 'Adelanto (90%)',
                'row_cost' => 'Costo estimado',
                'row_holdback' => 'Saldo al cobro',
                'cta' => 'Solicitar este monto',
                'note' => 'Estimación referencial con un adelanto del 90% y una tasa ilustrativa del 2% mensual. No constituye una solicitud formal ni una obligación de financiamiento.',
            ],
            'lead_form' => [
                'title' => 'Déjanos tus datos',
                'lead' => 'Con tu correo, WhatsApp y NIT te contactamos sobre este monto.',
                'email_label' => 'Correo',
                'whatsapp_label' => 'WhatsApp',
                'nit_label' => 'NIT',
                'submit' => 'Quiero que me contacten',
                'sending' => 'Enviando…',
                'success_title' => 'Listo. Nos vamos a comunicar contigo.',
                'success_text' => 'Recibimos tu solicitud y te escribimos a {email}. Un asesor te contactará por WhatsApp para revisar este monto.',
                'fine' => 'Usamos estos datos sólo para contactarte sobre este financiamiento.',
            ],
            'qualify' => [
                'eyebrow' => 'Califica en un minuto',
                'title' => '¿Es Facilita para mi empresa?',
                'lead' => 'Facilita puede ser para ti si:',
                'items' => [
                    'Vendes a empresas.',
                    'Facturas a crédito.',
                    'Tus clientes pagan a 30, 60, 90 o más días.',
                    'Tu empresa necesita liquidez antes de recibir esos pagos.',
                ],
            ],
            'footer' => [
                'text' => 'Financiamiento al ritmo de los negocios. Adelantamos el cobro de tus facturas para que el flujo de caja no limite tu crecimiento.',
                'copyright' => 'Facilita Capital. Todos los derechos reservados.',
            ],
            'mobile_cta' => 'Solicitar financiamiento',
            'mail' => [
                'subject' => 'Recibimos tu solicitud en Facilita Capital',
                'greeting' => 'Hola,',
                'body' => 'Recibimos tu solicitud para adelantar facturas por {amount}, con un plazo de {days} días. Con la estimación de hoy podrías recibir {today}. Nos vamos a comunicar contigo pronto por WhatsApp o por este correo.',
                'closing' => 'Facilita Capital',
            ],
        ];
    }

    /**
     * @param  array<string, mixed>  $defaults
     * @param  array<string, mixed>  $saved
     * @return array<string, mixed>
     */
    public static function merge(array $defaults, array $saved): array
    {
        foreach ($defaults as $key => $value) {
            if (! array_key_exists($key, $saved)) {
                $saved[$key] = $value;

                continue;
            }

            if (is_array($value) && is_array($saved[$key]) && ! array_is_list($value)) {
                $saved[$key] = self::merge($value, $saved[$key]);
            }
        }

        return $saved;
    }

    /**
     * @param  array<string, mixed>  $colors
     * @return array<string, string>
     */
    public static function colorVariables(array $colors): array
    {
        $safe = [];

        foreach ($colors as $name => $value) {
            if (! is_string($name) || ! is_string($value) || ! preg_match('/^#[0-9A-Fa-f]{6}$/', $value)) {
                continue;
            }

            $safe[str_replace('_', '-', $name)] = $value;
        }

        return $safe;
    }

    public static function url(?string $path): string
    {
        if ($path === null || $path === '') {
            return '';
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/')) {
            return $path;
        }

        $basename = basename($path);
        if (array_key_exists($basename, self::packagedImages())) {
            return '/images/'.$basename;
        }

        $disk = config('filesystems.media_disk', 'public');
        if (! is_string($disk) || $disk === '' || $disk === 'public' || $disk === 'local') {
            return '/storage/'.ltrim($path, '/');
        }

        return Storage::disk($disk)->url($path);
    }

    public static function ensureImages(): void
    {
        $disk = Storage::disk('public');

        foreach (self::packagedImages() as $source => $destination) {
            if ($disk->exists($destination)) {
                continue;
            }

            $absolute = public_path('images/'.$source);
            if (! is_file($absolute)) {
                continue;
            }

            $disk->put($destination, (string) file_get_contents($absolute));
        }
    }

    /**
     * @return array<string, string>
     */
    public static function packagedImages(): array
    {
        return [
            'hero-emprendedora.jpg' => 'site/hero-emprendedora.jpg',
            'problem-negocio.jpg' => 'site/problem-negocio.jpg',
            'case-daniela.jpg' => 'site/case-daniela.jpg',
            'case-andres.jpg' => 'site/case-andres.jpg',
            'case-camila.jpg' => 'site/case-camila.jpg',
            'case-luis.jpg' => 'site/case-luis.jpg',
        ];
    }

    public static function replaceTokens(string $template, Lead $lead): string
    {
        return strtr($template, [
            '{amount}' => Finance::money($lead->invoice_amount),
            '{today}' => Finance::money($lead->payout_amount),
            '{days}' => (string) $lead->term_days,
            '{email}' => $lead->email,
            '{whatsapp}' => $lead->whatsapp,
            '{nit}' => $lead->nit,
            '{min}' => Finance::money(Finance::MIN_AMOUNT),
            '{max}' => Finance::money(Finance::MAX_AMOUNT),
        ]);
    }

    public static function fillTemplate(string $template, array $replacements): string
    {
        return strtr($template, $replacements);
    }
}
