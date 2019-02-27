<?php
/** @var \Carbon\Carbon $date */
?>
Olá,<br><br>
segue a soma de todas as vendas efetuadas no dia hoje ({{ $date->format('d/m/Y') }}).

<h1>R$ {{ $total }}</h1>