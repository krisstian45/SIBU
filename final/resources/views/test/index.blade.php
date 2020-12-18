<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<title>{{ $article->title }}</title>
	<!-- Formas de integrar archivos -->
	<!-- Forma 1: Escribiendo el path a mano desde la carpeta root (que es la carpeta public) hasta el archivo a integrar -->
	<link rel="stylesheet" type="text/css" href="/css/general.css">
	<!-- Forma 2: Usando la funcion asset que provee blade y por defecto nos lleva a la carpeta root, luego desde ese punto de partida buscamos el archivo a integrar -->
	<link rel="stylesheet" type="text/css" href="{{ asset('css/general.css') }}">
</head>
<body>
	HOLA CODIGO FACILITO

	<br><br>
	<h1>{{ $article->title }}</h1>
	<hr>
	{{ $article->content }}
	<hr>
	{{ $article->user->name }} | {{ $article->category->name }} |

	@foreach($article->tags as $tag)
		{{ $tag->name }}
	@endforeach
</body>
</html>
