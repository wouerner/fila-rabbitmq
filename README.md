# fila-rabbitmq

diagrama: https://lucid.app/lucidchart/invitations/accept/inv_30bacc05-c53b-4da5-a11d-fcfc6491ad01?viewport_loc=-351%2C-39%2C2219%2C1013%2C0_0

Motivos 

* https://www.youtube.com/watch?v=FcF5iufd2P0&t=5s (basico)
* https://www.youtube.com/watch?v=YotzziZzKJo&t=3404s (pouco de codigo)
* https://www.youtube.com/watch?v=xpwmMarGtwE
* https://www.youtube.com/watch?v=yL1BPIw2ihY&t=423s (BR RabbitMQ e Apache Kafka -  Michelli Brito)


Iniciar o projeto  
`
docker-compose up 
`

links:  

* http://localhost:9090/pedido.html
* http://localhost:8080/#/

### Estruturas

Exchanges:
* pedido_exchange

Queue:
* distributor_queue
* email_queue

Porque?

* grande volume de informações.
* queda dos serviços
* robustez 

## Cenario

fazer um pedido, e distribuir para 3 serviços diferentes email, distribuidor e pagamento.
Todos os serviços são assincronos.


Tecnologias:

* git
* (rabbitmq) [https://www.rabbitmq.com/]
* vim
* tmux
* firefox
* OBS
* PHP
* composer




