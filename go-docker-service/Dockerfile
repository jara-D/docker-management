# --- Build stage ---
FROM golang:1.25-alpine AS builder

WORKDIR /src

RUN apk add --no-cache gcc g++ libc-dev

ENV CGO_ENABLED=1 GOOS=linux GOARCH=amd64

COPY . .
RUN go build -o /bin/server ./cmd/server

# --- Dev stage ---
FROM golang:1.25-alpine AS dev

WORKDIR /app

RUN apk add --no-cache gcc g++ libc-dev
RUN go install github.com/air-verse/air@latest

COPY . .

CMD ["air"]

# --- Production stage ---
FROM alpine:3.19

WORKDIR /app

COPY --from=builder /bin/server /bin/server

EXPOSE 8080
CMD ["/bin/server"]
