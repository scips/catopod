<?php

declare(strict_types=1);

namespace App\Views\Components\Forms;

class MultiSelect extends FormComponent
{
    /**
     * @var array<string, string>
     */
    protected array $options = [];

    /**
     * @var string[]
     */
    protected array $selected = [];

    public function setOptions(string $value): void
    {
        $this->options = json_decode(html_entity_decode($value), true);
    }

    public function setSelected(string $selected): void
    {
        $this->selected = json_decode($selected);
    }

    public function render(): string
    {
        $defaultAttributes = [
            'data-class' => $this->attributes['class'],
            'multiple' => 'multiple',
        ];
        $extra = array_merge($defaultAttributes, $this->attributes);

        return form_dropdown($this->name, $this->options, $this->selected, $extra);
    }
}