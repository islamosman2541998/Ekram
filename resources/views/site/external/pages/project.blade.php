@extends('site.external.app')

@section('title', @$project->trans?->where('locale', $current_lang)->first()->title)
@section('meta_key', @$project->trans?->where('locale', $current_lang)->first()->meta_key)
@section('meta_description', @$project->trans?->where('locale', $current_lang)->first()->meta_description)

@section('content')

<main>
    <div class="container  project-page">
        <livewire:site.external.projects :project="$project" :refer="$refer" />
    </div>
</main>

@endsection
