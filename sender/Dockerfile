FROM node:12.18.3
WORKDIR /app/
RUN npm install amqplib
COPY app.js /app/
CMD ["node", "app.js"]