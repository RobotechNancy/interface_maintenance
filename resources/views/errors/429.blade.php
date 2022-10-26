@extends('errors::minimal')

@section('title', __('Trop de requêtes transmises'))
@section('code', '429')

@section('message', __("La limite de requêtes envoyées est atteinte, veuillez réessayer ultérieurement."))