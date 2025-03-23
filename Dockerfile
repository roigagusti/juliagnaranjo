# Usa una imagen oficial de Python como base
FROM python:3.9-slim

# Establece el directorio de trabajo en el contenedor
WORKDIR /app

# Copia los archivos de Poetry y los instala
COPY pyproject.toml /app/

# Instala dependencias mínimas de sistema necesarias para Poetry
RUN apt-get update && apt-get install -y \
    build-essential \
    && rm -rf /var/lib/apt/lists/*

# Instala Poetry
RUN pip install poetry

# Instala las dependencias del proyecto sin instalar el propio proyecto
RUN poetry install --no-root

# Copia el código fuente al contenedor
COPY src/ /app/src

# Set the working directory to /app/src
WORKDIR /app/src

# Exponer el puerto necesario
EXPOSE 80

# Comando para ejecutar la aplicación
CMD ["poetry", "run", "python", "app.py"]



# To create Docker image
# docker build -t roigagusti/julianaranjo:v0.2.0 .
# docker build -t roigagusti/julianaranjo:latest .

# To push to Docker Hub
# docker push roigagusti/julianaranjo:v0.2.0
# docker push roigagusti/julianaranjo:latest



### To export the Docker image
### docker save -o julianaranjo_v0.2.0.tar julianaranjo_v0.2.0:latest