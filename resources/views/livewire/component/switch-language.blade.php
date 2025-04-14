<div class="nav-link dropdown">
  <a class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
    {{ _app('Language') }} <i class="bi bi-translate"></i>
  </a>

  <ul class="dropdown-menu bg-secondary">
    <li><a class="dropdown-item bg-{{ Auth::user()->language == 'English' ? 'primary' : '' }}"
        wire:click='swich_language("English")'>🇬🇧 English</a></li>
    <li><a class="dropdown-item bg-{{ Auth::user()->language == 'Arabic' ? 'primary' : '' }}" href="#"
        wire:click='swich_language("Arabic")'>🇸🇦 Arabic</a></li>
    <li><a class="dropdown-item bg-{{ Auth::user()->language == 'French' ? 'primary' : '' }}" href="#"
        wire:click='swich_language("French")'>🇫🇷 French</a></li>
    <li><a class="dropdown-item bg-{{ Auth::user()->language == 'Spanish' ? 'primary' : '' }}" href="#"
        wire:click='swich_language("Spanish")'>🇪🇸 Spanish</a></li>
  </ul>
</div>
