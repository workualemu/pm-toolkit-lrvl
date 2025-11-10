@if(config('commentify.comment_nesting') === true)
    @auth
        @if($comment->isParent())
            <button type="button" wire:click="$toggle('isReplying')"
                    class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium text-primary-700 bg-primary-50 hover:bg-primary-100 dark:text-primary-200 dark:bg-navy-700 dark:hover:bg-navy-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10l-3-3m3 3l-3 3M14 7h4a2 2 0 012 2v6a2 2 0 01-2 2h-4" />
                </svg>
                Reply
            </button>
            <div wire:loading wire:target="$toggle('isReplying')">
                @include('commentify::livewire.partials.loader')
            </div>
        @endif
    @endauth
    @if($comment->children->count())
        <button type="button" wire:click="$toggle('hasReplies')"
                class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 dark:text-slate-200 dark:bg-navy-700 dark:hover:bg-navy-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-400">
            @if(!$hasReplies)
                View all Replies ({{$comment->children->count()}})
            @else
                Hide Replies
            @endif
        </button>
        <div wire:loading wire:target="$toggle('hasReplies')">
            @include('commentify::livewire.partials.loader')
        </div>
    @endif
@endif

