@extends('admin.app')

@section('title', trans('volunteers.show_ideas'))
@section('title_page', trans('volunteers.idea'))
@section('title_route', route('admin.volunteers-ideas.index') )

@section('button_page')
<a href="{{ route('admin.volunteers-ideas.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('tell/intlTelInput.css') }}" />
@endsection

@section('content')

<div class="card">

    <div class="row d-flex justify-content-center">
        <div class="col-md-12">

            <div class="accordion" id="accordionExample">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">
                            <span class=" text-primary "> {{ $idea->subject }}</span>
                        </button>
                    </h2>
                    <div id="collapseOne1" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">

                            <div class="col-12 col-lg-12 p-lg-4 border-R-15 rounded">
                                <div class="WriteArea mx-auto p-3 text-center rounded">

                                    <h2 class="text-primary my-2 me-3 fw-bold">
                                        {{ $idea->subject }}
                                    </h2>

                                    <div class="form-control p-3 text-center">
                                        <h5 class="text-start fw-bold text-dark"> {{ $idea->name }}</h5>
                                        <p>
                                            {{ $idea->message  }}
                                        </p>
                                    </div>

                                    <div class="icons my-3 d-flex justify-content-start">

                                        <div class="i like rounded-circle mx-3" wire:click="loves">
                                            <span>
                                                {{ count($idea['loves']) }}
                                            </span>
                                            <i class="bx bxs-heart text-danger"></i>
                                        </div>

                                        <div class="i comment rounded-circle" wire:click="showCommentModel()" class="btn" data-bs-toggle="modal" data-bs-target="#addComment">
                                            <span>
                                                {{ count($idea->comments) }}
                                            </span>
                                            <i class='bx bxs-chat text-primary'></i>
                                        </div>

                                        <!-- Modal -->
                                        @if(@$showModalComent)
                                        <div class="modal fade show" id="addComment" style="display: block;" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel"> @lang('volunteers.add_comment_in') {{ $idea->subject }} </h5>
                                                        <button type="button" class="btn-close" wire:click="closeCommentModel()" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="">
                                                            <div class="row px-2 mt-2">
                                                                <label for="exampleInputIdentify" class="form-label col-12 mt-1 text-end"> @lang('volunteers.name') </label>
                                                                <input type="text" wire:model="name" class="form-control" id="exampleInputName" required />
                                                                @error('name')
                                                                <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="mt-3 row">
                                                                <label class="form-label col-12 mt-1 text-end"> @lang('volunteers.comment') </label>
                                                                <div class="WriteArea mx-auto border-R-15">
                                                                    <textarea wire:model="comment" class="form-control p-3" required placeholder=""></textarea>
                                                                </div>
                                                                @error('comment')
                                                                <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary btn-sm" wire:click="addComment()">@lang('Send')</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif




                                    </div>

                                    @if($idea->comments)
                                    <h4 class="text-black d-flex justify-content-start pt-3">@lang('volunteers.comments'):</h4>
                                    @forelse ($idea->comments as $comment)
                                    <div class="row m-3">
                                        <div class="col-11 bg-light p-3 text-start rounded-6">
                                            <p>
                                                <span class="text-primary fw-bold">{{ $comment->name }} : </span>
                                                <span>{{ $comment->comment }}</span>
                                            </p>
                                        </div>
                                        <div class="col-1 display-6 my-auto">
                                            <form action="{{ route('admin.volunteers-ideas-comment.destroy', $comment->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this comment?')">
                                                    <i class='bx bx-x-circle'></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    @empty

                                    @endforelse
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Start Info User --}}


        </div>


        <div class="row mb-3 text-end">
            <div>
                <a href="{{ route('admin.volunteers-ideas.index') }}" class="btn btn-outline-primary waves-effect waves-light  btn-sm">@lang('button.cancel')</a>
            </div>
        </div>
    </div>
</div>
@endsection
