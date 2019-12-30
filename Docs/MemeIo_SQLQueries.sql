--Post with comments

SELECT
		post.Id AS Id,
        post.title AS Title,
        post.creatorId AS CreatorId,
        post.categoryId AS CategoryId,
        post.picturePath AS PicturePath,
        post.uploadDate AS UploadDate,
        (
            SELECT
            		username
            	FROM
            		user
            	WHERE
            		user.Id = post.creatorId
        ) AS CreatorName,
        (
            SELECT
            		name
            	FROM
            		category
            	WHERE	
            		categoryId = category.Id
        ) AS CategoryName,
        (
            SELECT
            		comment.Id AS Id,
            		comment.creatorId AS CreatorId,
            		comment.uploadDate AS UploadDate,
            		comment.text AS Text,
            		comment.picturePath AS PicturePath,
            		(
            			SELECT
            				username
            			FROM
            				user
            			WHERE
            				user.Id = comment.creatorId
        			) AS CreatorName
           		FROM
            		post AS comment
            	WHERE
            		comment.parentId = post.Id
        ) AS Comments
    FROM
    	post
    WHERE
    	post.parentId IS NULL