# Guide d'utilisation - Best Practices Laravel

## Table des matieres

1. [Enums](#enums)
2. [Traits](#traits)
3. [Policies](#policies)
4. [Events](#events)
5. [Resources](#resources)
6. [Form Requests](#form-requests)
7. [Patterns](#patterns)

---

## Enums

### PostStatus

```php
use App\Enums\PostStatus;

$post->status = PostStatus::PUBLISHED;

if ($post->status === PostStatus::PUBLISHED) {
    //
}

echo $post->status->label();
$color = $post->status->color();
$icon = $post->status->icon();
PostStatus::options();
```

### PostVisibility

```php
use App\Enums\PostVisibility;

$post->visibility = PostVisibility::PRIVATE;

if ($post->visibility === PostVisibility::PUBLIC) {
    //
}
```

---

## Traits

### HasSlug

Genere automatiquement des slugs uniques.

```php
class Post extends Model
{
    use HasSlug;

    protected function getSlugSourceColumn(): string
    {
        return 'title';
    }
}
```

### HasMedia

Centralise la gestion des fichiers.

```php
class PostMedia extends Model
{
    use HasMedia;
}

$url = $media->getFileUrl($media->path);
echo $media->sizeFormatted();
$media->delete();
```

### HasReadingTime

Calcule automatiquement le temps de lecture.

```php
class Post extends Model
{
    use HasReadingTime;
}

$time = $post->calculateReadingTime($post->body);
echo $post->reading_time_formatted;
```

### Filterable

Permet un filtrage dynamique.

```php
$posts = Post::filter(request()->only([
    'search',
    'category',
    'tag',
    'status',
    'visibility',
    'date_from',
    'date_to',
]))->get();
```

---

## Policies

### Utilisation dans les controllers

```php
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AdminBlogController extends Controller
{
    use AuthorizesRequests;

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
    }
}
```

### Utilisation dans les vues

```blade
@can('update', $post)
    <a href="{{ route('admin.posts.edit', $post) }}">Editer</a>
@endcan

@cannot('delete', $post)
    <span>Suppression indisponible</span>
@endcannot
```

### Utilisation avec Gate

```php
if (Gate::allows('update', $post)) {
    //
}
```

---

## Events

### Dispatcher un event

```php
use App\Events\PostPublished;

$post = Post::create($data);
PostPublished::dispatch($post);
```

### Ecouter un event

```php
Event::listen(PostPublished::class, function (PostPublished $event) {
    //
});
```

### Ajouter un listener

```bash
php artisan make:listener SendPostPublishedNotification
```

```php
Event::listen(
    PostPublished::class,
    SendPostPublishedNotification::class,
);
```

---

## Resources

### Exemple de controller avec Form Request

```php
use App\Http\Resources\PostResource;

return PostResource::make($post);
return PostResource::collection($posts);
```

### Exemple de structure JSON

```json
{
  "id": 1,
  "title": "Mon Article",
  "slug": "mon-article",
  "status": "published",
  "status_label": "Publie",
  "visibility": "public",
  "visibility_label": "Public",
  "reading_time": 5,
  "views_count": 42
}
```

### Relations conditionnelles

```php
'category' => PostCategoryResource::make($this->whenLoaded('category'));
```

---

## Form Requests

### Creer une FormRequest

```bash
php artisan make:request BlogPostRequest
```

### Structure type

```php
class BlogPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|min:5',
            'status' => Rule::enum(PostStatus::class),
        ];
    }
}
```

### Utilisation dans un controller

```php
public function store(BlogPostRequest $request): RedirectResponse
{
    $validated = $request->validated();

    Post::create($validated);
}
```

---

## Patterns

### Pattern 1 - Eager loading

```php
$posts = Post::with('category')->get();
```

### Pattern 2 - Scopes chainables

```php
$posts = Post::published()
    ->featured()
    ->latest()
    ->paginate(15);
```

### Pattern 3 - Conditional queries

```php
$query = Post::query();

if ($request->has('category')) {
    $query->where('category_id', $request->category);
}

$posts = $query->get();
```

### Pattern 4 - Observer pattern

```php
class PostObserver
{
    public function creating(Post $post): void
    {
        $post->admin_id = auth('admin')->id();
    }
}
```

### Pattern 5 - Repository pattern

```php
interface PostRepositoryInterface
{
    public function getPublished();
}
```

---

## Checklist avant commit

- [ ] Utiliser des Form Requests pour la validation
- [ ] Verifier les policies
- [ ] Eviter les N+1 queries
- [ ] Dispatcher les events utiles
- [ ] Utiliser les enums plutot que des chaines
- [ ] Prevoir des tests unitaires et feature

---

## Ressources officielles

- [Laravel Policies](https://laravel.com/docs/authorization#creating-policies)
- [Laravel Events](https://laravel.com/docs/events)
- [Laravel Resources](https://laravel.com/docs/eloquent-resources)
- [Laravel Validation](https://laravel.com/docs/validation)

---

Version: 1.0
Date: 2026-03-21
Framework: Laravel 11.31+
