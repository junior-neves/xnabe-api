Olá! Bem-vindo ao meu projeto secreto!

###Objetivo Principal
Implementar a API da maneira mais simples que eu conseguisse.

###Minha Idéia
Optei por não utilizar nenhum framework para poder ter mais liberdade de mostrar a arquitetura que planejei. 
Ainda assim utilizei duas bibliotecas de terceiros, uma para tratar das rotas e uma para tratar dos requests e responses.   

O fluxo dos dados da API é:
> routes.php > Controller > Service > Repository > Database

Meu foco principal foi desacoplar as camadas do sistema para que ele pudesse escalar e ter manutenção de forma segura no futuro.
Para isso eu utilizei o design pattern **Repository-Service**. Nele, a regra de negócio fica apenas dentro do **Service** e a conexão com o banco fica apenas no **Repository**.

Assim, caso precisássemos substituir o formato de banco atual (que é uma conexão Mysql via PDO), o Service não precisaria de nenhuma alteração.

Tanto os Services quanto os Repositories possuem **Interfaces** (contracts) para que as novas implementações sigam os mesmos padrões e também para que o conceito de **Inversão de Dependência** do SOLID seja seguido.
Por conta dele, tanto o Controller quanto o Service dependem apenas de interfaces, e não de objetos instanciados.

Relacionado a isso, eu criei duas classes auxiliares, a ServiceProvider e a RepositoryProvider. Elas possuem uma lista de quais controllers-services-repositories precisam um do outro.
Assim, quando o controller é chamado no routes.php eu consigo usar o design pattern **Dependency Injection** e já chamar o controller com o Service instanciado (e o Service já vem com os Repositories instanciados também) 

Desta forma o código fica bem separado e, apesar de parecer mais complexo, fica mais fácil de fazer alterações em sua estrutura no futuro.

###TODO List

Algumas coisas que eu gostaria de fazer mas não tive tempo:

- Classe para validação dos dados (adicionaria essa validação em uma camada extra entre o Controller e o Service)
- Testes
- Factory Method para separar os tipos de eventos (deposit, withdraw, transfer)
- Exceptions
- Model para Account (assim eu não precisaria forçar a tipagem no metodo getAccount do EventService)

