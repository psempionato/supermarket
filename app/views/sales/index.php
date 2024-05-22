<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Venda</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        let produtos = [];

        function addProduct() {
            const produtoInput = document.getElementById('produto');
            const quantidadeInput = document.getElementById('quantidade');
            const produtoName = produtoInput.value;
            const quantity = quantidadeInput.value;

            if (produtoName && quantity) {
                fetch(`/get-product-by-name?name=${encodeURIComponent(produtoName)}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json', 
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data) {
                        taxAmount = calculateTax(data.price, data.tax_percentage, quantity);
                        totalAmount = calculateTotal(data.price, quantity, taxAmount);

                        produtos.push({ id: data.id, name: data.name, quantity: quantity, unitPrice: data.price, total: totalAmount, taxAmount: taxAmount });
                        refreshTable();

                        produtoInput.value = '';
                        quantidadeInput.value = '';

                        totalSaleAndTax();
                    } else {
                        alert('Produto não encontrado!');
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('Ocorreu um erro ao buscar o produto!');
                });
            } else {
                alert('Por favor, preencha todos os campos.');
            }
        }

        function calculateTax(amount, taxPercentage, quantity) {
            const tax = ((amount * taxPercentage) / 100) * quantity;
            return parseFloat(tax.toFixed(2));
        }

        function calculateTotal(unitPrice, quantity, taxAmount) {
            const subtotal = unitPrice * quantity;
            return subtotal + taxAmount;
        }

        function totalSaleAndTax(){
            let totalSale = 0;
            let totalTax = 0;

            produtos.forEach((produto, index) => {
                totalSale = totalSale + produto.total;
                totalTax = totalTax + produto.taxAmount;
            });
            
            document.getElementById('total-sale').textContent = "R$ " + totalSale.toFixed(2);
            document.getElementById('total-tax').textContent = "R$ " + totalTax.toFixed(2);
        }

        function refreshTable() {
            const tabela = document.getElementById('tabela-produtos');
            tabela.innerHTML = '';

            produtos.forEach((produto, index) => {
                const row = tabela.insertRow();
                row.insertCell(0).innerText = produto.name;
                row.insertCell(1).innerText = produto.quantity;
                row.insertCell(2).innerText = produto.unitPrice;
                row.insertCell(3).innerText = produto.total;
                row.insertCell(4).innerText = produto.taxAmount;
                const cell = row.insertCell(5);
                const button = document.createElement('button');
                button.innerText = 'Remover';
                button.classList.add('bg-red-500', 'hover:bg-red-700', 'text-white', 'font-bold', 'py-2', 'px-4', 'rounded', 'focus:outline-none', 'focus:shadow-outline');
                button.onclick = () => removeProduct(index);
                cell.appendChild(button);
            });
        }

        function removeProduct(index) {
            produtos.splice(index, 1);
            refreshTable();
            totalSaleAndTax();
        }

        function saveSale() {
            if (produtos.length > 0) {
                console.log("produtos", produtos);
                fetch('/store-sale', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(produtos)
                }).then(response => {
                    if (response.ok) {
                        alert('Venda salva com sucesso!');
                        produtos = [];
                        document.getElementById('total-sale').textContent = "R$ 0.00";
                        document.getElementById('total-tax').textContent = "R$ 0.00";
                        refreshTable();
                        totalSaleAndTax();
                    } else {
                        alert('Erro ao salvar a venda.');
                    }
                });
            } else {
                alert('Adicione pelo menos um produto.');
            }
        }
    </script>
</head>
<body>
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-6">Tela de Venda</h1>
        <div class="space-y-4">
            <div>
                <label for="produto" class="block text-gray-700 font-medium">Produto</label>
                <input type="text" id="produto" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label for="quantidade" class="block text-gray-700 font-medium">Quantidade</label>
                <input type="number" id="quantidade" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="text-right">
                <button onclick="addProduct()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 mt-2">
                    Adicionar
                </button>
            </div>
        </div>
        <table class="table-auto w-full mt-6">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 text-left text-gray-600">Produto</th>
                    <th class="px-4 py-2 text-left text-gray-600">Quantidade</th>
                    <th class="px-4 py-2 text-left text-gray-600">Preço Unitário</th>
                    <th class="px-4 py-2 text-left text-gray-600">Total</th>
                    <th class="px-4 py-2 text-left text-gray-600">Impostos</th>
                    <th class="px-4 py-2 text-left text-gray-600">Ações</th>
                </tr>
            </thead>
            <tbody id="tabela-produtos" class="bg-white">
                <!-- Produtos adicionados aparecerão aqui -->
            </tbody>
        </table>


        <div class="mt-6 p-4 bg-gray-100 rounded-lg shadow-inner">
            <div class="flex justify-between items-center mb-2">
                <span class="text-lg font-medium text-gray-700">Total de Compras:</span>
                <span id="total-sale" class="text-lg font-bold text-gray-900">R$ 0.00</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-lg font-medium text-gray-700">Total de Impostos:</span>
                <span id="total-tax" class="text-lg font-bold text-gray-900">R$ 0.00</span>
            </div>
        </div>

        <div class="text-right">
            <button onclick="saveSale()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mt-4">Salvar Venda</button>
        </div>
    </div>
</body>
</html>