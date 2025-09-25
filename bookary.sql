--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE categorias (
  "id" SERIAL PRIMARY KEY,
  "nombre" varchar(100) NOT NULL,
  "descripcion" varchar(255) DEFAULT NULL
);

---

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE libros (
  "id" SERIAL PRIMARY KEY,
  "titulo" varchar(255) NOT NULL,
  "autor" varchar(255) NOT NULL,
  "editorial" varchar(255) DEFAULT NULL,
  "año_publicacion" INT DEFAULT NULL,
  "isbn" varchar(20) DEFAULT NULL,
  "ejemplares" int DEFAULT 1,
  "ubicacion" varchar(100) DEFAULT NULL,
  "id_categoria" int
);

ALTER TABLE libros
  ADD CONSTRAINT libros_id_categoria_fkey FOREIGN KEY ("id_categoria") REFERENCES categorias("id");

---

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE prestamos (
  "id" SERIAL PRIMARY KEY,
  "id_libro" int NOT NULL,
  "id_usuario" int NOT NULL,
  "fecha_prestamo" date NOT NULL,
  "fecha_devolucion" date NOT NULL,
  "fecha_devuelto" date DEFAULT NULL,
  "estado" varchar(20) DEFAULT 'activo'
);

---

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE reservas (
  "id" SERIAL PRIMARY KEY,
  "id_usuario" int NOT NULL,
  "id_libro" int NOT NULL,
  "fecha_reserva" date NOT NULL,
  "estado" varchar(20) DEFAULT 'pendiente'
);

---

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE users (
  "id" SERIAL PRIMARY KEY,
  "password" varchar(255) NOT NULL,
  "username" varchar(255) NOT NULL,
  "role" varchar(255) DEFAULT 'estudiante'
);

---

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO users ("id", "password", "username", "role") VALUES
(1, '123', 'sara', 'estudiante'),
(2, '12345', 'Angel', 'Administrador');

---

--
-- Filtros para la tabla `prestamos`
--
ALTER TABLE prestamos
  ADD CONSTRAINT prestamos_id_libro_fkey FOREIGN KEY ("id_libro") REFERENCES libros("id"),
  ADD CONSTRAINT prestamos_id_usuario_fkey FOREIGN KEY ("id_usuario") REFERENCES users("id");

---

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE reservas
  ADD CONSTRAINT reservas_id_usuario_fkey FOREIGN KEY ("id_usuario") REFERENCES users("id"),
  ADD CONSTRAINT reservas_id_libro_fkey FOREIGN KEY ("id_libro") REFERENCES libros("id");

---
-- Índice para buscar libros por categoría
CREATE INDEX idx_libros_id_categoria ON libros(id_categoria);

-- Índices para acelerar búsquedas y relaciones en préstamos
CREATE INDEX idx_prestamos_id_libro ON prestamos(id_libro);
CREATE INDEX idx_prestamos_id_usuario ON prestamos(id_usuario);

-- Índices para reservas
CREATE INDEX idx_reservas_id_libro ON reservas(id_libro);
CREATE INDEX idx_reservas_id_usuario ON reservas(id_usuario);

-- Índice para búsquedas rápidas de usuario
CREATE INDEX idx_users_username ON users(username);