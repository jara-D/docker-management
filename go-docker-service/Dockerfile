# --- Build stage ---
FROM golang:1.25-alpine AS builder

WORKDIR /src

# Install build dependencies
RUN apk add --no-cache gcc g++ libc-dev

ENV CGO_ENABLED=1 GOOS=linux GOARCH=amd64

# Copy source code
COPY . .

# Build binary into /src/server
RUN go build -o server ./cmd/server


# --- Dev stage ---
FROM golang:1.25-alpine AS dev

WORKDIR /app

# Install Air + build deps
RUN apk add --no-cache gcc g++ libc-dev
RUN go install github.com/air-verse/air@latest

# Copy source code
COPY . .

CMD ["air"]


# --- Production stage ---
FROM alpine:3.19

WORKDIR /app

# Install runtime dependencies (needed for CGO)
RUN apk add --no-cache libc6-compat

# Copy binary from builder
COPY --from=builder /src/server /app/server

EXPOSE 8080

CMD ["/app/server"]
