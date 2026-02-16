FROM golang:1.24.3-alpine AS builder

WORKDIR /go-docker-service
COPY . .
RUN go build -o server ./cmd/server

FROM alpine:3.19
WORKDIR /app
COPY --from=builder /go-docker-service/server .
EXPOSE 8081
CMD ["./server"]
