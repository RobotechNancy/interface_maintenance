@extends('errors.minimal')

@section('title', __('Accès non autorisé'))
@section('code', '403')

@auth
  @section('message', __("Votre compte n'est pas autorisé à accéder à cette page."))
@else
  @section('message', __("Vous n'êtes pas connecté et cette page n'est pas disponible sans connexion."))
@endauth
