<div class="card">
    <div class="px-3 pt-4 pb-2">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img style="width:50px" class="me-2 avatar-sm rounded-circle"
                    src="https://api.dicebear.com/6.x/fun-emoji/svg?seed={{ $idea->user->name }}" alt="Mario Avatar">
                <div>
                    <h5 class="card-title mb-0"><a href="#"> {{ $idea->user->name }}
                        </a></h5>
                </div>
            </div>
            <div>
                <form method="POST" action="{{ route('ideas.destroy', $idea->id) }}">
                    @csrf
                    <a href="{{ route('ideas.show', $idea->id) }}"> View </a>
                    @if (auth()->id() == $idea->user_id)
                        @method('delete')
                        <a class="mx-2" href="{{ route('ideas.edit', $idea->id) }}"> Edit </a>
                        <button class="btn btn-danger btn-sm ms-1">x</button>
                    @endif
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if ($editing ?? false)
            <form action="{{ route('ideas.update', [$idea->id]) }}" method="POST">
                @csrf
                @method('put')
                <div class="mb-3">
                    <textarea name="content" class="form-control" id="content" rows="3">{{ $idea->content }}</textarea>
                    @error('content')
                        <span class=" fs-6 text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="">
                    <button type="submit" class="btn btn-dark mb-2"> update </button>
                </div>
            </form>
        @else
            <p class="fs-6 fw-light text-muted">
                {{ $idea->content }}
            </p>
        @endif
        <div class="d-flex justify-content-between">
            <div>
                <form action="{{ route('idea.like', $idea) }}" method="POST">
                    @csrf
                    <button class="btn btn-sm me-1 d-flex">
                        @php
                            $likes = json_decode($idea->like);
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
            <div>
                <span class="fs-6 fw-light text-muted"> <span class="fas fa-clock">
                    </span>
                    {{ $idea->created_at }} </span>
            </div>
        </div>
        @include('shared.comments_box')
    </div>
</div>
