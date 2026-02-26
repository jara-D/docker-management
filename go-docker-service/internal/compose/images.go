package compose

//
//import (
//	"context"
//	"fmt"
//	//"io"
//
//	//"github.com/moby/moby/api/types/image"
//	"github.com/moby/moby/client"
//)
//
//func pullImageIfNeeded(ctx context.Context, cli *client.Client, imageName string) error {
//
//	images, err := cli.ImageList(ctx, client.ImageListOptions{})
//	if err != nil {
//		return fmt.Errorf("failed to list images: %w", err)
//	}
//
//	fmt.Printf("Pulling %s...\n", images)
//
//	//for _, img := range images {
//	//	for _, tag := range client.ImgRepoTags {
//	//		if tag == imageName {
//	//			return nil // image exists
//	//		}
//	//	}
//	//}
//	//
//	//// Pull image if not found
//	//fmt.Println("Pulling image:", imageName)
//	//
//	//reader, err := cli.ImagePull(ctx, imageName, image.PullOptions{})
//	//if err != nil {
//	//	return fmt.Errorf("failed to pull image %s: %w", imageName, err)
//	//}
//	//defer reader.Close()
//	//
//	//// Drain the stream
//	//_, _ = io.Copy(io.Discard, reader)
//
//	return nil
//}
