@if ($paginator->hasPages())
    <ul class="flex justify-between" >
        @if ($paginator->onFirstPage())
            <li class="w-16 px-2 py-1 text-center rounded border adow bg-gray-200 "> Prev </li>
        @else
            <li class="w-16 px-2 py-1 text-center rounded border shadow bg-white cursor-pointer"
                wire:click="previousPage"> Prev </li>
        @endif

        <div class="flex">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled d-none d-md-block" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif
    
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="mx-2 w-10 px-2 py-1 text-center rounded border shadow bg-blue-500 text-white cursor-pointer"> 
                            {{ $page }}</li>
                        @else
                            <li class="mx-2 w-10 px-2 py-1 text-center rounded border shadow bg-white cursor-pointer"  
                            wire:click.defer="gotoPage({{ $page }})">{{ $page }}</li>
                        @endif
                    @endforeach
                @endif
            @endforeach 
        </div>

        @if ($paginator->hasMorePages())
            <li class="w-16 px-2 py-1 text-center rounded border shadow bg-white cursor-pointer" 
                wire:click="nextPage"> Next </li>
        @else
            <li class="w-16 px-2 py-1 text-center rounded border bg-gray-200 "> Next </li>
        @endif

        
        
 
       

    </ul>
@endif