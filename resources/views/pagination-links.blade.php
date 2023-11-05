@if ($paginator->hasPages())
    <div class="flex justify-between" >
            @if ($paginator->onFirstPage())
                <div class="w-16 px-2 py-1 text-center rounded border adow bg-gray-200 "> Prev </div>
            @else
                <div class="w-16 px-2 py-1 text-center rounded border shadow bg-white cursor-pointer hover:text-white hover:bg-slate-600"
                    wire:click="previousPage"> Prev </div>
            @endif
            <p class="text-sm leading-5 text-gray-700">
                Showing
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                to
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
                of
                <span class="font-medium">{{ $paginator->total() }}</span>
                records
            </p>
        <div class="flex">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <button class="page-item disabled d-none d-md-block" aria-disabled="true"><span class="page-link">{{ $element }}</span></button>
                @endif
    
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <button class="w-10 px-1 py-1 text-center rounded border shadow bg-blue-500 text-white cursor-pointer"> 
                            {{ $page }}</button>
                        @else
                            <button class="w-10 px-1 py-1 text-center rounded border shadow bg-white cursor-pointer hover:text-white hover:bg-slate-600"  
                            wire:click="gotoPage({{ $page }})">{{ $page }}</button>
                        @endif
                    @endforeach
                @endif
            @endforeach 
        </div>

        @if ($paginator->hasMorePages())
            <div class="w-16 px-2 py-1 text-center rounded border shadow bg-white cursor-pointer hover:text-white hover:bg-slate-600" 
                wire:click="nextPage"> Next </div>
        @else
            <div class="w-16 px-2 py-1 text-center rounded border bg-gray-200 "> Next </div>
        @endif

        
        
 
       

</div>
@endif