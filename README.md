# fila-rabbitmq

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
