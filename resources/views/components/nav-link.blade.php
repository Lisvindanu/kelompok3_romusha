@props(['active' => false])
<a {{ $attributes }}
    class="{{ $active ? 'bg-yellow-400 px-3 py-2 text-sm font-medium text-red-700' : 'rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-yellow-500 hover:text-red-700' }} rounded-md font-pixelify"
    aria-current="{{ $active ? 'page' : false }}">{{ $slot }}</a>

