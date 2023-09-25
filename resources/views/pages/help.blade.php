@extends('layout')

@section('title')
Raspadinha Premiada - Ajuda e Suporte Técnico
@stop

@section('content')
<div class="navigator-line">
	<div class="container">
		<div class="navigator-line__wrapper">
			<button class="button-round button-round_trans-dark" onclick="window.history.back()">
				<i class="button-round__icon button-round__icon_f-left fa fa-chevron-left" aria-hidden="true"></i>
				Voltar
			</button>
			<h1 class="navigator-line__text">Ajuda - FAQ</h1>
		</div>
	</div>
</div>
<div class="help">
	<div class="container container_full-width">
		<div class="row">
                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1 col-lg-offset-2">
				<div id="faq-help" class="help__faq-wrapper faq">
					<h2 class="faq__header">Perguntas Frequentes</h2>
					<div class="faq__block">
						<div class="faq__block-header">
							<h3 data-block="#faq-help" class="faq__block-header-text faq__block-header-text_active">Como jogar?</h3>
						</div>
						<div class="faq__block-text" style="display: block;">
							<ul>
<li>— Escolha o valor de sua aposta, clique no botão "Iniciar o jogo"</li>
<li>— Raspe a camada protetora do cartão com seu mouse ou dedo</li>
<li>— Raspe 3 números, se forem iguais - ganhe um prêmio dependendo da aposta</li>
<li>— Raspe 2 números, se forem iguais - abra o 4º cartão ou ganhe um prêmio garantido</li>
							</ul>
						</div>
					</div>
					<div class="faq__block">
						<div class="faq__block-header">
							<h3 data-block="#faq-help" class="faq__block-header-text faq__block-header-text_noactive">Como inserir um código promocional?</h3>
						</div>
						<div class="faq__block-text">
							No menu, clique no link "Bônus" e insira o código promocional na janela que aparece. O presente será creditado no saldo instantaneamente.
						</div>
					</div>
					<div class="faq__block">
						<div class="faq__block-header">
							<h3 data-block="#faq-help" class="faq__block-header-text faq__block-header-text_noactive">O que é o modo de demonstração?</h3>
						</div>
						<div class="faq__block-text">
Demo é um modo no qual você pode experimentar o jogo sem reabastecer seu saldo.
O algoritmo e os resultados do jogo serão os mesmos de quando se joga para equilibrar. No entanto, no modo de demonstração o dinheiro não é retirado do saldo e os ganhos não são creditados.
						</div>
					</div>
					<div class="faq__block">
						<div class="faq__block-header">
							<h3 data-block="#faq-help" class="faq__block-header-text faq__block-header-text_noactive">Como jogar com dinheiro real?</h3>
						</div>
						<div class="faq__block-text">
Para jogar a dinheiro real com a possibilidade de sacar para a carteira, é necessário reabastecer o saldo.
						</div>
					</div>
					<div class="faq__block">
						<div class="faq__block-header">
							<h3 data-block="#faq-help" class="faq__block-header-text faq__block-header-text_noactive">A retirada de dinheiro é instantânea?</h3>
						</div>
						<div class="faq__block-text">
PIX e Yandex são retirados em alguns minutos. Retirada para depósito bancário pode demorar
de 1 hora a 3 dias úteis (dependendo do seu banco).
						</div>
					</div>
					<div class="faq__block">
						<div class="faq__block-header">
							<h3 data-block="#faq-help" class="faq__block-header-text faq__block-header-text_noactive">Como convidar um amigo?</h3>
						</div>
						<div class="faq__block-text">
						@php
						$settings = \DB::table('settings')->where('id', 1)->first();
						@endphp
Vá para a seção "Backoffice", onde você encontrará seu código promocional pessoal.<br><br>
Copie e envie para um amigo. Quando um amigo o ativar, ele receberá {{$settings->promo_sum}} em créditos e
você receberá {{$settings->promo_percent}}% de todas as recargas dele!
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop