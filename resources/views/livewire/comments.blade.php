<div>
    <section class="bg-white dark:bg-gray-900 py-8 lg:py-16">
        <div class="max-w-2xl mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <label class="block">
                    <span>Comments ({{$comments->count()}}) </span>
                </label>
            </div>
            @auth
                @include('livewire.partials.comment-form',[
                    'method'=>'postComment',
                    'state'=>'newCommentState',
                    'inputId'=> 'comment',
                    'inputLabel'=> 'Your comment',
                    'button'=>'Post comment'
                ])
            @else
                <a class="mt-2 text-sm" href="/login">Log in to comment!</a>
            @endauth
            @if($comments->count())
                @foreach($comments as $comment)
                    <livewire:comment :comment="$comment" :key="$comment->id"/>
                @endforeach
                {{$comments->links()}}
            @else
                <p>No comments yet!</p>
            @endif
        </div>
    </section>
</div>
