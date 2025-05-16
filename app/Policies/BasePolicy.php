<?php

namespace App\Policies;

use App\Models\AboutMe;
use App\Models\Post;
use App\Models\PostTranslation;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

abstract class BasePolicy
{
    private array $cvModels = ['aboutme', 'contactinfo', 'experience', 'portfolio', 'skill'];

    protected function hasAccess(User $user, string $action): bool
    {
        $model = $this->getModelNameFromPolicy();
        if ($model == 'post' || $model == 'posttranslation') {
            return $user->can("blog.{$action}");
        } elseif (in_array($model, $this->cvModels)) {
            return $user->can("cvinfo.{$action}");
        }

        return $user->can("{$model}.{$action}");
    }

    public function viewAny(User $user): bool
    {
        $model = $this->getModelNameFromPolicy();
        if ($model == 'post' || $model == 'posttranslation') {
            return $user->can('blog.index');
        } elseif (in_array($model, $this->cvModels)) {
            return $user->can('cvinfo.index');
        }

        return $user->can("{$model}.index");
    }

    public function view(User $user, Model $model): bool
    {
        return $this->hasAccess($user, 'view');
    }

    public function create(User $user): bool
    {
        return $this->hasAccess($user, 'create');
    }

    public function update(User $user, Model $model): bool
    {
        return $this->hasAccess($user, 'edit');
    }

    public function delete(User $user, Model $model): bool
    {
        return $this->hasAccess($user, 'delete');
    }

    protected function getModelNameFromPolicy(): string
    {
        $class = static::class;
        $parts = explode('\\', $class);
        $policyClass = end($parts);
        return strtolower(str_replace('Policy', '', $policyClass));
    }
}
