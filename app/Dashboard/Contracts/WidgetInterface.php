<?php

namespace App\Dashboard\Contracts;

interface WidgetInterface
{
    public function getKey(): string;

    public function getTitle(): string;

    public function getComponent(): string;

    public function getPermissions(): array;

    public function getGroup(): string;

    public function getPosition(): int;

    public function isVisible(): bool;

    public function getData(): array;

    public function isLazy(): bool;

    public function gridSpan(): int;
}
