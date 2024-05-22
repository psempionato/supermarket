<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mx-auto p-4">
        <h1 class="text-4xl font-bold text-center">Lista de Impostos</h1>
        <div class="flex justify-end mt-4">
            <a href="/add-taxes" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mr-4">
                Adicionar Novo Valor de Imposto
            </a>
        </div>
        <table class="table-auto w-full mt-4">
            <thead>
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Tipo de Produto</th>
                    <th class="px-4 py-2">Porcentagem(%)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($taxes as $tax): ?>
                <tr>
                    <td class="border px-4 py-2"><?= htmlspecialchars($tax['id']) ?></td>
                    <td class="border px-4 py-2"><?= htmlspecialchars($tax['product_type']) ?></td>
                    <td class="border px-4 py-2"><?= htmlspecialchars($tax['tax_percentage']) ?></td>
                    <td class="border px-4 py-2 flex justify-center items-center"> 
                        <form method="POST" action="/delete-tax">
                            <input type="hidden" name="tax_id" value="<?= htmlspecialchars($tax['id']) ?>">
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                                Excluir
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>