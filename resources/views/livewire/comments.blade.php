<div>
    <span>Comments ({{$comments->count()}}) </span>
    @auth
        @include('commentify::livewire.partials.comment-form',[
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
