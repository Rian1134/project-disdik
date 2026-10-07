{{--
    Komponen: Accordion (wadah)
    Fungsi: Membungkus beberapa <x-accordion.item> menjadi satu grup.

    Props:
    - id       : string wajib, id unik grup accordion
    - multiple : boolean, true = boleh banyak item terbuka sekaligus, false = single (default: false)

    Contoh:
    <x-accordion id="faqAccordion">
        <x-accordion.item title="Apa itu Laravel?">
            Laravel adalah framework PHP.
        </x-accordion.item>
        <x-accordion.item title="Apakah gratis?">
            Ya, Laravel open source dan gratis.
        </x-accordion.item>
    </x-accordion>
--}}
@props([
    'id',
    'multiple' => false,
])

<div
    id="{{ $id }}"
    data-accordion
    data-accordion-multiple="{{ $multiple ? 'true' : 'false' }}"
    {{ $attributes->class(['divide-y divide-gray-200 dark:divide-gray-700 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden']) }}
>
    {{ $slot }}
</div>
