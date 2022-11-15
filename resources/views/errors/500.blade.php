@extends('errors.minimal')

@section('title', __('Problème de serveur'))
@section('code', '500')

@section('message', __("Un problème a été rencontré lors de la communication avec le serveur, veuillez réessayer ultérieurement."))
