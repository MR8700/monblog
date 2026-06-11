<div class="flex flex-wrap justify-center gap-4 mb-6">

    <a href="{{ route('admin.products.index') }}" 
       class="flex items-center gap-2 px-4 py-2 rounded-full border border-gray-300 bg-gray-50 text-gray-700 font-semibold 
              hover:bg-gray-100 hover:scale-105 transition transform duration-200">
        <i class="fas fa-list"></i> Tous
    </a>

    <a href="{{ route('admin.products.index', ['status' => 'published']) }}" 
       class="flex items-center gap-2 px-4 py-2 rounded-full border border-green-400 bg-green-50 text-green-700 font-semibold 
              hover:bg-green-100 hover:scale-105 transition transform duration-200">
        <i class="fas fa-check-circle"></i> Publiés
    </a>

    <a href="{{ route('admin.products.index', ['status' => 'unpublished']) }}" 
       class="flex items-center gap-2 px-4 py-2 rounded-full border border-yellow-400 bg-yellow-50 text-yellow-700 font-semibold 
              hover:bg-yellow-100 hover:scale-105 transition transform duration-200">
        <i class="fas fa-times-circle"></i> Non publiés
    </a>

    <a href="{{ route('admin.products.index', ['sort' => 'price_desc']) }}" 
       class="flex items-center gap-2 px-4 py-2 rounded-full border border-purple-400 bg-purple-50 text-purple-700 font-semibold 
              hover:bg-purple-100 hover:scale-105 transition transform duration-200">
        <i class="fas fa-arrow-up"></i> Plus chers
    </a>

</div>
