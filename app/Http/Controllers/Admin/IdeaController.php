<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IdeaController extends Controller
{
    public function index(Request $request)
    {
        $query = Idea::query()->with(['category.translations', 'translations']);

        if ($search = trim((string) $request->get('q'))) {
            $query->where(function ($q) use ($search) {
                $q->where('slug', 'like', "%{$search}%")
                  ->orWhereHas('translations', function ($t) use ($search) {
                      $t->where('title', 'like', "%{$search}%");
                  });
            });
        }
        if ($cat = $request->get('category')) $query->where('category_id', $cat);
        if ($status = $request->get('status')) {
            if ($status === 'published') $query->where('is_published', true);
            elseif ($status === 'draft') $query->where('is_published', false);
            elseif ($status === 'featured') $query->where('is_featured', true);
        }

        $ideas = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        $categories = Category::with('translations')->where('type', 'idea')->orderBy('sort_order')->get();
        return view('admin.ideas.index', compact('ideas', 'categories'));
    }

    public function create()
    {
        $categories = Category::with('translations')->where('type', 'idea')->orderBy('sort_order')->get();
        return response()->view('admin.ideas.form', [
            'categories' => $categories,
            'idea'       => null,
            'en'         => null,
        ])->withHeaders(['Cache-Control' => 'no-store']);
    }

    public function store(Request $request)
    {
        file_put_contents(storage_path('logs/idea-debug.log'), date('H:i:s') . ' REQUEST: ' . json_encode($request->only(['slug','capital','expected_profit','currency'])) . PHP_EOL, FILE_APPEND);
        $data = $this->validateIdea($request);
        $slug = $this->makeUniqueSlug($data['slug'] ?? '', $data['en_title'] ?? '', null);

        DB::transaction(function () use ($data, $request, $slug) {
            $idea = new Idea();
            $this->fillIdea($idea, $data, $request, $slug);
            $idea->save();

            $idea->translations()->create([
                'locale'            => 'en',
                'title'             => $data['en_title'],
                'short_description' => $data['en_short_description'] ?? null,
                'full_description'  => $data['en_full_description'] ?? null,
                'steps'             => $data['en_steps'] ?? null,
                'requirements'      => $data['en_requirements'] ?? null,
                'tips'              => $data['en_tips'] ?? null,
            ]);
        });

        return redirect()->route('admin.ideas.create')
            ->with('success', 'Idea created. You can add another one below.');
    }

    public function show(Idea $idea)
    {
        $idea->load(['category.translations', 'translations']);
        return view('admin.ideas.show', compact('idea'));
    }

    public function edit(Idea $idea)
    {
        $idea->load(['category.translations', 'translations']);
        $categories = Category::with('translations')->where('type', 'idea')->orderBy('sort_order')->get();
        $en = $idea->translations->firstWhere('locale', 'en');
        return response()->view('admin.ideas.form', [
            'categories' => $categories,
            'idea'       => $idea,
            'en'         => $en,
        ])->withHeaders(['Cache-Control' => 'no-store']);
    }

    public function update(Request $request, Idea $idea)
    {
        $data = $this->validateIdea($request);
        $slug = $this->makeUniqueSlug($data['slug'] ?? '', $data['en_title'] ?? '', $idea->id);

        DB::transaction(function () use ($idea, $data, $request, $slug) {
            $this->fillIdea($idea, $data, $request, $slug);
            $idea->save();
            $idea->translations()->updateOrCreate(
                ['locale' => 'en'],
                [
                    'title'             => $data['en_title'],
                    'short_description' => $data['en_short_description'] ?? null,
                    'full_description'  => $data['en_full_description'] ?? null,
                    'steps'             => $data['en_steps'] ?? null,
                    'requirements'      => $data['en_requirements'] ?? null,
                    'tips'              => $data['en_tips'] ?? null,
                ]
            );
        });

        return redirect()->route('admin.ideas.show', $idea)
            ->with('success', 'Idea updated successfully.');
    }

    public function destroy(Idea $idea)
    {
        DB::transaction(function () use ($idea) {
            $idea->delete();
        });

        return redirect()->route('admin.ideas.index')
            ->with('success', 'Idea deleted.');
    }

    public function togglePublish(Idea $idea)
    {
        $idea->is_published = ! $idea->is_published;
        $idea->published_at = $idea->is_published ? ($idea->published_at ?: now()) : null;
        $idea->save();
        return back()->with('success', $idea->is_published ? 'Idea published.' : 'Idea unpublished.');
    }

    public function toggleFeatured(Idea $idea)
    {
        $idea->is_featured = ! $idea->is_featured;
        $idea->save();
        return back()->with('success', $idea->is_featured ? 'Idea featured.' : 'Idea unfeatured.');
    }

    protected function fillIdea(Idea $idea, array $data, Request $request, string $slug): void
    {
        $idea->fill([
            'category_id'      => $data['category_id'] ?? null,
            'slug'             => $slug,
            'cover_image'      => $data['cover_image'] ?? null,
            'capital'          => $data['capital'] ?? null,
            'expected_profit'  => $data['expected_profit'] ?? null,
            'currency'         => $data['currency'] ?? 'RWF',
            'difficulty_level' => $data['difficulty_level'] ?? null,
            'time_to_start'    => $data['time_to_start'] ?? null,
            'operating_costs'  => $data['operating_costs'] ?? null,
            'expected_revenue' => $data['expected_revenue'] ?? null,
            'is_featured'      => $request->boolean('is_featured'),
            'is_published'     => $request->boolean('is_published'),
            'published_at'     => $request->boolean('is_published')
                                    ? ($idea->published_at ?: now())
                                    : null,
        ]);
    }

    protected function validateIdea(Request $request): array
    {
        return $request->validate([
            'slug'              => ['nullable', 'string', 'max:191'],
            'category_id'       => ['nullable', 'integer', 'exists:categories,id'],
            'cover_image'       => ['nullable', 'string', 'max:500'],
            'capital'           => ['nullable', 'numeric', 'min:0', 'max:999999999999999999'],
            'expected_profit'   => ['nullable', 'numeric', 'max:999999999999999999'],
            'currency'          => ['nullable', 'string', 'max:10'],
            'difficulty_level'  => ['nullable', 'in:easy,medium,hard'],
            'time_to_start'     => ['nullable', 'string', 'max:191'],
            'operating_costs'   => ['nullable', 'numeric'],
            'expected_revenue'  => ['nullable', 'numeric'],
            'is_featured'       => ['nullable', 'boolean'],
            'is_published'      => ['nullable', 'boolean'],
            'en_title'             => ['required', 'string', 'max:191'],
            'en_short_description' => ['nullable', 'string'],
            'en_full_description'  => ['nullable', 'string'],
            'en_steps'             => ['nullable', 'string'],
            'en_requirements'      => ['nullable', 'string'],
            'en_tips'              => ['nullable', 'string'],
        ]);
    }

    protected function makeUniqueSlug(string $slug, string $title, ?int $ignoreId = null): string
    {
        $base = $slug !== '' ? $slug : $title;
        $base = Str::slug($base);
        if ($base === '') $base = 'idea';

        $candidate = $base;
        $i = 1;
        while (
            Idea::where('slug', $candidate)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $i++;
            $candidate = $base . '-' . $i;
        }
        return $candidate;
    }
}
