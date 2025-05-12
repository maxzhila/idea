<div>
    @auth
        <form action="{{ route('ideas.comments.store', $idea) }}" method="get">
            @csrf
            <div class="mb-3">
                <textarea name="content" class="fs-6 form-control" rows="1"></textarea>
            </div>
            <div>
                <button type="submit" class="btn btn-primary btn-sm"> Post Comment </button>
            </div>
        </form>
    @endauth
    <hr>
    @foreach ($idea->comments as $comment)
        <div class="d-flex align-items-start">

            <div>
                <img style="width:50px" class="me-2 avatar-sm rounded-circle"
                    src="https://api.dicebear.com/6.x/fun-emoji/svg?seed={{ $comment->user->name }}" alt="Mario Avatar">
                <form action="{{ route('comments.like', $comment) }}" method="POST">
                    @csrf
                    <button class="btn btn-sm me-1 d-flex">
                        @php
                            $likes = json_decode($comment->like);
                        @endphp
                        @if (in_array(auth()->id(), $likes))
                            <span class="fas fa-heart me-1"></span>
                        @else
                            <span class="fa-regular fa-heart me-1"></span>
                        @endif
                        {{ count($likes) }}
                    </button>
                </form>
            </div>
            <div class="w-100">
                <div class="d-flex justify-content-between">
                    <h6 class="">{{ $comment->user->name }}</h6>
                    <h6>{{ $comment->created_at }}</h6>
                    @if (auth()->id() == $comment->user->id)
                        <div>
                            <form action="{{ route('comments.destroy', $comment) }}" method="POST"
                                style="display:inline;">
                                @csrf

                                @method('DELETE')
                                <button class="btn btn-danger btn-sm ms-1">x</button>
                            </form>
                        </div>
                    @endif
                </div>
                <p class="fs-6 mt-3 fw-light">
                    {{ $comment->content }}
                </p>
            </div>
        </div>
    @endforeach
</div>
