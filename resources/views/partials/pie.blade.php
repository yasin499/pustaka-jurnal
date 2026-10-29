@php
  $sum = array_sum(array_column($data, 'n'));
  $acc = 0;
  $stops = [];
  foreach ($data as $d) {
      if ($d['n'] > 0) {
          $from = round($acc / $sum * 100, 2);
          $acc += $d['n'];
          $stops[] = $d['color'].' '.$from.'% '.round($acc / $sum * 100, 2).'%';
      }
  }
@endphp
<section class="panel">
  <h2>{{ $title }}</h2>
  @if($sum > 0)
    <div class="pie-wrap">
      <div class="pie-chart" role="img" aria-label="Diagram lingkaran {{ $title }}" style="background: conic-gradient({{ implode(', ', $stops) }})"></div>
      <ul class="legend">
        @foreach($data as $label => $d)
          <li>
            <i style="background: {{ $d['color'] }}"></i>
            @if(! empty($d['url']))<a href="{{ $d['url'] }}">{{ $label }}</a>@else {{ $label }} @endif
            : <b>{{ $d['n'] }}</b> ({{ round($d['n'] / $sum * 100) }}%)
          </li>
        @endforeach
      </ul>
    </div>
    @if(! empty($note))<p class="mute">{{ $note }}</p>@endif
  @else
    <p class="mute">{{ $empty ?? 'Belum ada data untuk ditampilkan.' }}</p>
  @endif
</section>
