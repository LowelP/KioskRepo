<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="style.css" rel="stylesheet">
  <title>Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet"/>
  <style>
    body {
      font-family: "Roboto", sans-serif;
    }
    .text-shadow {
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }
    .icon-wrapper {
      transition: background-color 0.3s ease, transform 0.3s ease;
    }
    .icon-wrapper.active {
      background-color: white;
      border-radius: 0.5rem;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transform: scale(1.1);
    }
  </style>
</head>
<body class="bg-white min-h-screen flex flex-col">