@props(['active' => false])

@php
    $classes = "block text-left px-3 text-s leading-5 hover:bg-blue-500 focus:bg-blue-500 hover:text-white focus:text-white";

    $classes .= ($active)?' bg-blue-500 text-white': '';
@endphp

<a {{ $attributes(["class"=>$classes])}} >{{$slot}}</a>
