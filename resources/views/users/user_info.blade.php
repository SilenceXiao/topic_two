<a href="{{ route('users.show', $user->id) }}">
  <img src="{{ $user->gravatar('100') }}" alt="{{ $user->name }}" class="gravatar"/>

  <!-- <img src="/images/header.gif" alt="{{ $user->name }}" class="gravatar"/> -->
</a>
<h1>{{ $user->name }}</h1>