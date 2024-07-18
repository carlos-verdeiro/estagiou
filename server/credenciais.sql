# Privilégios para `cnpjSelect`@`%`

GRANT USAGE ON *.* TO `cnpjSelect`@`%` IDENTIFIED BY PASSWORD '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257';

GRANT SELECT (`cnpj`) ON `estagiou`.`escola` TO `cnpjSelect`@`%`;

GRANT SELECT (`cnpj`) ON `estagiou`.`empresa` TO `cnpjSelect`@`%`;


# Privilégios para `curriculoInsertEstagiario`@`%`

GRANT USAGE ON *.* TO `curriculoInsertEstagiario`@`%` IDENTIFIED BY PASSWORD '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257';

GRANT SELECT (`id`), INSERT (`curriculo_id`), UPDATE (`curriculo_id`) ON `estagiou`.`estagiario` TO `curriculoInsertEstagiario`@`%`;

GRANT SELECT (`estagiario_id`, `id`), INSERT, DELETE ON `estagiou`.`curriculo` TO `curriculoInsertEstagiario`@`%`;


# Privilégios para `curriculoSelectEstagiario`@`%`

GRANT USAGE ON *.* TO `curriculoSelectEstagiario`@`%` IDENTIFIED BY PASSWORD '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257';

GRANT SELECT (`curriculo_id`, `id`) ON `estagiou`.`estagiario` TO `curriculoSelectEstagiario`@`%`;

GRANT SELECT ON `estagiou`.`curriculo` TO `curriculoSelectEstagiario`@`%`;


# Privilégios para `emailSelect`@`%`

GRANT USAGE ON *.* TO `emailSelect`@`%` IDENTIFIED BY PASSWORD '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257';

GRANT SELECT (`email`) ON `estagiou`.`escola` TO `emailSelect`@`%`;

GRANT SELECT (`email`) ON `estagiou`.`estagiario` TO `emailSelect`@`%`;

GRANT SELECT (`email`) ON `estagiou`.`empresa` TO `emailSelect`@`%`;


# Privilégios para `empresaInsert`@`%`

GRANT USAGE ON *.* TO `empresaInsert`@`%` IDENTIFIED BY PASSWORD '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257';

GRANT INSERT ON `estagiou`.`escola` TO `empresaInsert`@`%`;

GRANT INSERT ON `estagiou`.`empresa` TO `empresaInsert`@`%`;


# Privilégios para `empresaSelect`@`%`

GRANT USAGE ON *.* TO `empresaSelect`@`%` IDENTIFIED BY PASSWORD '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257';


# Privilégios para `escolaInsert`@`%`

GRANT USAGE ON *.* TO `escolaInsert`@`%` IDENTIFIED BY PASSWORD '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257';

GRANT INSERT ON `estagiou`.`escola` TO `escolaInsert`@`%`;


# Privilégios para `estagiarioInsert`@`%`

GRANT USAGE ON *.* TO `estagiarioInsert`@`%` IDENTIFIED BY PASSWORD '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257';

GRANT INSERT ON `estagiou`.`estagiario` TO `estagiarioInsert`@`%`;


# Privilégios para `loginAll`@`%`

GRANT USAGE ON *.* TO `loginAll`@`%` IDENTIFIED BY PASSWORD '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257';

GRANT SELECT (`id`, `senha`, `email`) ON `estagiou`.`escola` TO `loginAll`@`%`;

GRANT SELECT (`id`, `senha`, `email`) ON `estagiou`.`empresa` TO `loginAll`@`%`;

GRANT SELECT (`id`, `senha`, `email`) ON `estagiou`.`estagiario` TO `loginAll`@`%`;


# Privilégios para `ultimoLoginUpdate`@`%`

GRANT USAGE ON *.* TO `ultimoLoginUpdate`@`%` IDENTIFIED BY PASSWORD '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257';

GRANT SELECT (`id`, `ultimo_login`), UPDATE (`ultimo_login`) ON `estagiou`.`empresa` TO `ultimoLoginUpdate`@`%`;

GRANT SELECT (`id`, `ultimo_login`), UPDATE (`ultimo_login`) ON `estagiou`.`escola` TO `ultimoLoginUpdate`@`%`;

GRANT SELECT (`id`, `ultimo_login`), UPDATE (`ultimo_login`) ON `estagiou`.`estagiario` TO `ultimoLoginUpdate`@`%`;