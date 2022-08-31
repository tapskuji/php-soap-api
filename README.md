# Creating a SOAP API in PHP

This is a tutorial on how to create a SOAP API in PHP.

In this project I use NuSOAP to create the SOAP web services and to consume the SOAP web services. 

The project has 7 tutorials that cover how to create different inputs and outputs (SOAP messages). It covers strings, integers, floats, booleans, arrays and complex types. The 8th tutorial an example of an API with CRUD fuctionality.

Each tutorial has server and a client and a README explaining the basic concepts of that tutorial.

## Setup

You need to install docker on your computer in order to run the project.
You can run the following command:

```bash
docker-compose up
```

When finished, you can see the application running at `localhost:80`.

This setup will install the following environment:

- Debian GNU/Linux 9
- PHP 5.6.40
- Apache/2.4.25 (Debian)
- Xdebug v2.2.7

You need to make sure port 80 is not being used. If you want to use Xdebug for debugging, allow port 9000 on your firewall.

If you want to stop the docker container you can use the following command:

```bash
docker-compose down
```
