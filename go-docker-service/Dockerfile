FROM golang:1.24.3-alpine AS builder

WORKDIR /go-docker-service

# Install build dependencies for CGO
RUN apk add --no-cache gcc g++ libc-dev

ENV CGO_ENABLED=1
ENV GOOS=linux
ENV GOARCH=amd64

COPY . .
RUN go build -o server ./cmd/server

FROM alpine:3.19
WORKDIR /app

COPY --from=builder /go-docker-service/server .

EXPOSE 8081
CMD ["./server"]
