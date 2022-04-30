
@extends('layouts.app')

@section('content')
 
<!-- component -->
<div class=" w-full min-h-screen bg-gray-50 flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
    <div class="w-full sm:max-w-md p-5 mx-auto">
      <h2 class="mb-12 text-center text-4xl font-extrabold uppercase ">Edit and Update Resume
          {{-- <center>
            <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
            <lottie-player src="https://assets3.lottiefiles.com/packages/lf20_lrw0segg.json"  background="transparent"  speed="1"  style="width: 150px; height: 150px;"  loop  autoplay></lottie-player>
          </center> --}}
      </h2>
      @livewire('resume.edit', [$resume])
    </div>
  </div>
@endsection
