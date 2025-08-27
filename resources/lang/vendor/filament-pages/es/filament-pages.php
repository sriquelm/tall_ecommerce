<?php
// Spanish translations for beier/filament-pages package.
// Only keys that are actually used in the project are included.
return [
    'filament' => [
        'modelLabel' => 'Página',
        'pluralLabel' => 'Páginas',
        'recordTitleAttribute' => 'title',
        'navigation' => [
            'label'   => 'Páginas',
            'icon'    => 'heroicon-o-document-text',
            'group'   => 'Contenido',
            'sort'    => 3,
        ],
        'form' => [
            'title' => [
                'label' => 'Título',
            ],
            'slug' => [
                'label' => 'Slug',
            ],
            'template' => [
                'label' => 'Plantilla',
            ],
            'published_at' => [
                'label'         => 'Publicado desde',
                'displayFormat' => 'd/m/Y',
            ],
            'published_until' => [
                'label'         => 'Publicado hasta',
                'displayFormat' => 'd/m/Y',
            ],
            'created_at' => [
                'label' => 'Creado',
            ],
            'updated_at' => [
                'label' => 'Actualizado',
            ],
        ],
        'table' => [
            'status' => [
                'published' => 'Publicado',
                'draft'     => 'Borrador',
            ],
        ],
    ],
];
