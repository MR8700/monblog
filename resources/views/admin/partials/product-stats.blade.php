<div class="flex flex-wrap justify-center gap-3 mb-6">
    <a href="{{ route('admin.products.index', ['status' => 'published']) }}" 
       class="px-4 py-2 rounded-full border border-green-400 hover:bg-green-50 transition">
        Publiés
    </a>
    <a href="{{ route('admin.products.index', ['status' => 'unpublished']) }}" 
       class="px-4 py-2 rounded-full border border-yellow-400 hover:bg-yellow-50 transition">
        Non publiés
    </a>
    <a href="{{ route('admin.products.index', ['sort' => 'price_desc']) }}" 
       class="px-4 py-2 rounded-full border border-purple-400 hover:bg-purple-50 transition">
        Plus chers
    </a>
</div>
