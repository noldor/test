"use strict";

class StatusCodes {
    static 400() { return 'Код ошибки: 400, Плохой, неверный запрос'};
    static 401() { return 'Код ошибки: 401, Не авторизован'};
    static 402() { return 'Код ошибки: 402, Необходима оплата'};
    static 403() { return 'Код ошибки: 403, Запрещено'};
    static 404() { return 'Код ошибки: 404, Не найдено'};
    static 405() { return 'Код ошибки: 405, Метод не поддерживается'};
    static 406() { return 'Код ошибки: 406, Неприемлемо'};
    static 407() { return 'Код ошибки: 407, Необходима аутентификация прокси'};
    static 408() { return 'Код ошибки: 408, Истекло время ожидания'};
    static 409() { return 'Код ошибки: 409, Конфликт'};
    static 410() { return 'Код ошибки: 410, Удалён'};
    static 411() { return 'Код ошибки: 411, Необходима длина'};
    static 412() { return 'Код ошибки: 412, Условие ложно'};
    static 413() { return 'Код ошибки: 413, Размер запроса слишком велик'};
    static 414() { return 'Код ошибки: 414, Запрашиваемый URI слишком длинный'};
    static 415() { return 'Код ошибки: 415, Неподдерживаемый тип данных'};
    static 416() { return 'Код ошибки: 416, Запрашиваемый диапазон не достижим'};
    static 417() { return 'Код ошибки: 417, Ожидаемое неприемлемо'};
    //static 422() { return 'Код ошибки: 422, Необрабатываемый экземпляр'};
    static 423() { return 'Код ошибки: 423, Заблокировано'};
    static 424() { return 'Код ошибки: 424, Невыполненная зависимость'};
    static 425() { return 'Код ошибки: 425, Неупорядоченный набор'};
    static 426() { return 'Код ошибки: 426, Необходимо обновление'};
    static 428() { return 'Код ошибки: 428, Необходимо предусловие'};
    static 429() { return 'Код ошибки: 429, Слишком много запросов'};
    static 431() { return 'Код ошибки: 431, Поля заголовка запроса слишком большие'};
    static 449() { return 'Код ошибки: 449, Повторить с'};
    static 451() { return 'Код ошибки: 451, Недоступно по юридическим причинам'};

    static 500() { return 'Код ошибки: 500, Внутренняя ошибка сервера'};
    static 501() { return 'Код ошибки: 501, Не реализовано'};
    static 502() { return 'Код ошибки: 502, Плохой, ошибочный шлюз'};
    static 503() { return 'Код ошибки: 503, Сервис недоступен'};
    static 504() { return 'Код ошибки: 504, Шлюз не отвечает'};
    static 505() { return 'Код ошибки: 505, Версия HTTP не поддерживается'};
    static 506() { return 'Код ошибки: 506, Вариант тоже проводит согласование'};
    static 507() { return 'Код ошибки: 507, Переполнение хранилища'};
    static 508() { return 'Код ошибки: 508, Обнаружено бесконечное перенаправление'};
    static 509() { return 'Код ошибки: 509, Исчерпана пропускная ширина канала'};
    static 510() { return 'Код ошибки: 510, Не расширено'};
    static 511() { return 'Код ошибки: 511, Требуется сетевая аутентификация'};
}

export default StatusCodes;