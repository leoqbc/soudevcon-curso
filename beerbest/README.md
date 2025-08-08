# App para o curso SouDevCon

Aqui trabalharemos nosso projeto evolutivo sobre o curso "Do Relacional ao NoSQL com PHP"

## Nome da aplicação BeerBest
Um sistema de busca de cervejas artesanais por Geolocalização, como funciona?

O app captura sua localização, você informa a distância de busca da região e lhe é mostrado as cervejas ao redor, também é
possível buscar por tipo de cerveja.

Passos mão na massa:

Dia 1:
1. Apresentação da problemática (filtro de positions)
2. Implementação da modularização busca por Geolocalização
3. Criação dos dados (Seeder)
4. Criando os módulos(repository)
5. Testando a busca

Dia 2:
1. Apresentação da problemática (problemas de performance)
2. Instalando o MongoDB
3. Adaptando a comunicação(Repository para MongoDB)
4. Testando o novo filtro
5. Considerações finais

Repositórios com as soluções: 
- branch: **Aula1** - Aula de Quarta-feira
- branch: **Aula2** - Aula de Quinta-feira

Exemplo de um GeoJson
```json
{
  "type": "FeatureCollection",
  "features": [
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "coordinates": [
          -46.631701391253756,
          -23.55344402149045
        ],
        "type": "Point"
      }
    }
  ]
}
```
