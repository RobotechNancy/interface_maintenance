@extends('errors::minimal')

@section('title', __('Service indisponible'))
@section('code', '503')

@section('message', __("Un problème a été rencontré lors de la tentative d'accès au service, veuillez réessayer ultérieurement."))