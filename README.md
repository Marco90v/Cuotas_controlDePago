# Control de Pagos o Cuotas
Este es una pequeña practica realizada con librearías AngularJs y Bootstrap en un nivel básico.

El sistema consiste en llevar un control de pago de un servicio, el sistema verifica que exista la base de datos, así como sus tablas y correspondientes campos, de no existir los crea.

Agrega nuevos usuarios, visualiza la lista de los usuarios, crea montos a cobrar por el servicio, el servicio es un servicio único por lo que muestra un historial de los montos establecidos.

Edita datos de los usuarios y realiza pagos de las cuotas pendiente.

El sistema cobra el mes vencido, usando la lógica de como funcionan las empresas de servicios, una vez vencido el mes vencido, el sistema desactivaría el usuario (detalle que no realiza este), y para realiza la activación del mismo debe cancelarse la deuda pendiente y el nuevo mes que comenzara a transcurrir y se paga por adelántalo.

Al momento de registrar un nuevo usuario se tomo por entendido que se realizo el pago del servicio por lo que el mismo se agrega.

En el historial de pago se refleja la fecha que corresponde al día en que se vence el plazo, por defecto se define en el primer día de cada mes, y la fecha de cancelación corresponde al día en que se esta realizando el pago.
