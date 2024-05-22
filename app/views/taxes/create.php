<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Impostos</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mx-auto p-4">
        <h1 class="text-4xl font-bold text-center">Cadastro de Imposto</h1>
        <form action="/store-tax" method="POST" class="mt-4">
            <div class="mb-4">
                <label for="product_type_id" class="block text-gray-700">Tipo de Produto</label>
                <select name="product_type_id" id="product_type_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <?php foreach ($productTypes as $productType): ?>
                        <option value="<?= $productType['id']; ?>"><?= htmlspecialchars($productType['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="price" class="block text-gray-700">Porcentagem(%)</label>
                <input type="number" step="0.01" name="price" id="price" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Cadastrar</button>
            </div>
        </form>
    </div>
</body>
</html>