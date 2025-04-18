<?php
require_once 'functions.php';

$prompt = $_GET['q'] ?? 'Jak działa RAG w połączeniu z LLM?';

$context = load_documents('./documents');
$fullPrompt = "Prompt: $prompt\n\nContext:\n$context";

$response = send_to_gemini($fullPrompt);
echo "<h2>LLM mit quasi-RAG PHP app</h2>";
echo "<h2>Prompt:</h2><p>$prompt</p>";
echo "<h2>Odpowiedź modelu:</h2><pre>$response</pre>";
